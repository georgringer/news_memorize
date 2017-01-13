<?php

namespace GeorgRinger\NewsMemorize\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * This file is part of the "news_memorize" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Class HashViewHelper
 */
class HashViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('id', 'integer', 'ID of a newsItem', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        return GeneralUtility::hmac($this->arguments['id'], 'news_memorize');
    }
}
