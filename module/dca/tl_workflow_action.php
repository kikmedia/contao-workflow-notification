<?php

$GLOBALS['TL_DCA']['tl_workflow_action']['metapalettes']['workflow_notification extends default'] = array(
    'config' => array('notification_id'),
);

$GLOBALS['TL_DCA']['tl_workflow_action']['fields']['notification_id'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_workflow_action']['notification_id'],
    'inputType' => 'select',
    'filter'    => true,
    'reference' => &$GLOBALS['TL_LANG']['workflow']['types'],
    'options_callback' => array
    (
        'Netzmacht\Contao\WorkflowNotification\Dca\Action',
        'getNotificationIds'
    ),
    'exclude'   => true,
    'eval'      => array(
        'tl_class'       => 'w50',
        'mandatory'      => true,
        'submitOnChange' => true,
        'includeBlankOption' => true,
    ),
    'sql'       => "int(10) NOT NULL default '0'",
);
