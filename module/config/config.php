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
