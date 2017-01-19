<?php

namespace GeorgRinger\NewsMemorize\Ajax;

use Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Utility\EidUtility;

class Eid
{

    const SESSION_KEY = 'news_memorize';

    /** @var FrontendUserAuthentication */
    protected $user = null;

    public function run()
    {
        try {
            $action = GeneralUtility::_GET('action');
            switch ($action) {
                case 'get':
                    $this->getIds();
                    break;
                case 'add':
                    $this->update();
                    break;
                case 'remove':
                    $this->remove();
                    break;
                case 'clearall':
                    $this->clearAll();
                default:
                    // do nothing
            }
        } catch (Exception $e) {
//            echo $e->getMessage();
            HttpUtility::setResponseCodeAndExit(HttpUtility::HTTP_STATUS_401);
        }
    }

    protected function update()
    {
        $newId = (int)GeneralUtility::_GET('news');
        if ($newId > 0) {
            $this->checkIfUserIsLoggedIn();
            $this->checkHash($newId);

            $user = $this->initUser();

            $list = $this->getUserSessionData($user);
            if (!empty($list)) {
                $list = json_decode($list, true);
            } else {
                $list = [];
            }

            if (!in_array($newId, $list)) {
                $list[] = $newId;
                $user->setAndSaveSessionData(self::SESSION_KEY, json_encode($list));
            }
        }
    }

    protected function remove()
    {
        $newId = (int)GeneralUtility::_GET('news');
        if ($newId > 0) {
            $this->checkIfUserIsLoggedIn();
            $this->checkHash($newId);

            $user = $this->initUser();

            $list = $this->getUserSessionData($user);
            if (!empty($list)) {
                $list = json_decode($list, true);
            }

            if (($key = array_search($newId, $list)) !== false) {
                unset($list[$key]);
                // keep order
                $list = array_values($list);
                $user->setAndSaveSessionData(self::SESSION_KEY, json_encode($list));
            }
        }
    }

    /**
     * Show all ids of user
     *
     * @return void
     */
    protected function getIds()
    {
        $this->checkIfUserIsLoggedIn();
        $data = [];
        $user = $this->initUser();
        $sessionData = $this->getUserSessionData($user);
        if (!empty($sessionData)) {
            $data = json_decode($sessionData, true);
        }
        echo json_encode($data);
    }

    protected function getUserSessionData(FrontendUserAuthentication $user)
    {
        return $user->getKey('user', self::SESSION_KEY);
    }

    protected function clearAll()
    {
        $user = $this->initUser();
        $user->setAndSaveSessionData(self::SESSION_KEY, '');
    }

    protected function checkIfUserIsLoggedIn()
    {
        $user = $this->initUser();
        $status = (is_array($user->user) && isset($user->user['uid']));

        if (!$status) {
            throw new \RuntimeException('No user logged in', 1484296210);
        }
    }

    protected function checkHash($newsId)
    {
        $hash = GeneralUtility::hmac((int)$newsId, 'news_memorize');
        if ($hash !== GeneralUtility::_GET('hash')) {
            throw new \RuntimeException('Hash wrong', 1484296210);
        }
    }

    /**
     * @return FrontendUserAuthentication
     */
    protected function initUser()
    {
        if (is_null($this->user)) {
            $this->user = EidUtility::initFeUser();
        }
        return $this->user;
    }
}

$call = new Eid();
$call->run();