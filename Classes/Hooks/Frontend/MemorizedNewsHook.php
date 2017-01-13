<?php

namespace GeorgRinger\NewsMemorize\Hooks\Frontend;

use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class MemorizedNewsHook {

    const SESSION_KEY = 'news_memorize';

    public function modify(array $params, NewsRepository $newsRepository) {
        $this->updateConstraints($params['demand'], $params['respectEnableFields'], $params['query'], $params['constraints']);
    }

    /**
     * @param \GeorgRinger\News\Domain\Model\Dto\NewsDemand $demand
     * @param bool $respectEnableFields
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $constraints
     */
    protected function updateConstraints($demand, $respectEnableFields, \TYPO3\CMS\Extbase\Persistence\QueryInterface $query, array &$constraints) {
        $action = $demand->getAction();
        if ($action === 'GeorgRinger\News\Controller\NewsController::memorizeListAction' && is_object($GLOBALS['TSFE'])) {
            $idList = $this->getList();

            $constraints[] = $query->in('uid', $idList);
        }
    }

    protected function getList() {
        /** @var FrontendUserAuthentication $user */
        $user = $GLOBALS['TSFE']->fe_user;

        $list = $user->getSessionData(self::SESSION_KEY);
        $list = json_decode($list, true);

        return $list;
    }
}