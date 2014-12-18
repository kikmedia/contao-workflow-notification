<?php

/**
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\WorkflowNotification\Subscriber;

use Netzmacht\Contao\WorkflowNotification\NotificationQueue;
use Netzmacht\Workflow\Transaction\Event\TransactionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Transaction subscriber binds the notification queue to the event based transaction handler of the workflow system.
 *
 * @package Netzmacht\Contao\WorkflowNotification
 */
class TransactionSubscriber implements EventSubscriberInterface
{
    /**
     * Notification queue.
     *
     * @var NotificationQueue
     */
    private $queue;

    /**
     * Construct.
     *
     * @param NotificationQueue $queue Notification queue.
     */
    public function __construct(NotificationQueue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TransactionEvent::TRANSACTION_COMMIT   => 'send',
            TransactionEvent::TRANSACTION_ROLLBACK => 'clear'
        );
    }

    /**
     * Send all notifications.
     *
     * @return void
     */
    public function send()
    {
        $this->queue->send();
    }

    /**
     * Clear notifications.
     *
     * @reutrn void
     */
    public function clear()
    {
        $this->queue->clear();
    }
}
