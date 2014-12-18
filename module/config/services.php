<?php

global $container;

$container['workflow.notification.queue'] = $container->share(function () {
    return new \Netzmacht\Contao\WorkflowNotification\NotificationQueue();
});
