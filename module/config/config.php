<?php

use Netzmacht\Contao\WorkflowNotification\NotificationQueue;
use Netzmacht\Contao\WorkflowNotification\Subscriber\TransactionSubscriber;
use Netzmacht\Contao\WorkflowNotification\Subscriber\WorkflowSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

$GLOBALS['TL_HOOKS']['initializeDependencyContainer'][] = function(\Pimple $container) {
    /** @var EventDispatcherInterface $dispatcher */
    $dispatcher = $container['event-dispatcher'];

    /** @var NotificationQueue $queue */
    $queue = $container['workflow.notification.queue'];

    $dispatcher->addSubscriber(new TransactionSubscriber($queue));

    try {
        $dispatcher->addSubscriber(new WorkflowSubscriber($container['user'], \Config::get('dateFormat')));
    } catch (\Exception $e) {

    }
};

$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['workflow'] = array
(
    'workflow_notification' => array
    (
        'recipients'    => array('entity_*', 'properties_*', 'step_*', 'transition_*', 'user_email'),
        'email_subject' => array('entity_*', 'properties_*', 'step_*', 'transition_*', 'date', 'entityId', 'user_*'),
        'email_text'    => array('entity_*', 'properties_*', 'step_*', 'transition_*', 'date', 'entityId', 'user_*'),
        'email_html'    => array('entity_*', 'properties_*', 'step_*', 'transition_*', 'date', 'entityId', 'user_*'),
        'file_content'  => array('entity_*', 'properties_*', 'step_*', 'transition_*', 'date', 'entityId', 'user_*'),
    )
);
