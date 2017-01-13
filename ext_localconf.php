<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['switchableControllerActions']['newItems']['News->memorizeList'] = 'Memorize List';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Controller/NewsController'][] = 'news_memorize';

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['memorize'] = 'EXT:news_memorize/Classes/Ajax/Eid.php';

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded'][$_EXTKEY]
    = \GeorgRinger\NewsMemorize\Hooks\Frontend\MemorizedNewsHook::class . '->modify';