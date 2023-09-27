<?php

defined('TYPO3') || die('Access denied.');

call_user_func(function () {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools::class]['flexParsing'][]
        = \In2code\PowermailCleaner\Hooks\FlexFormHook::class;

    $cmsLayout = 'cms/layout/class.tx_cms_layout.php';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$cmsLayout]['tt_content_drawItem']['powermail'] =
        \In2code\PowermailCleaner\Hooks\PluginPreview::class;

    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \In2code\Powermail\Controller\FormController::class,  // Signal class name
        'createActionAfterMailDbSaved',                                  // Signal name
        \In2code\PowermailCleaner\Hooks\AfterMailSave::class,        // Slot class name
        'attachPlugin'                               // Slot name
    );
});
