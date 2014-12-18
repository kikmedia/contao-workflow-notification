<?php

/**
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\WorkflowNotification;

use NotificationCenter\Model\Notification;

/**
 * NotificationQueue is designed as a
 *
 * @package Netzmacht\Contao\WorkflowNotification
 */
class NotificationQueue
{
    private $notifications = array();

    /**
     * Add notification.
     *
     * @param int   $notificationId Notification id.
     * @param array $data           Data for notification tokens.
     * @param null  $language       Optional language.
     *
     * @return $this
     */
    public function add($notificationId, $data, $language = null)
    {
        $this->notifications[$notificationId] = array('data' => $data, 'language' => $language);

        return $this;
    }

    /**
     * Clear notifications.
     *
     * @return void
     */
    public function clear()
    {
        $this->notifications = array();
    }

    /**
     * Send notifications.
     *
     * @param bool $clear Clear notifications after sending them.
     *
     * @return void
     */
    public function send($clear = true)
    {
        $notificationIds = array_keys($this->notifications);
        $collection      = NotificationCenter::findMultipleByIds($notificationIds);

        if (!$collection) {
            return;
        }

        foreach ($collection as $notification) {
            $message = $this->notifications[$collection->id];
            $notification->current()->send($message['data'], $message['language']);
        }

        if ($clear) {
            $this->clear();
        }
    }
}
