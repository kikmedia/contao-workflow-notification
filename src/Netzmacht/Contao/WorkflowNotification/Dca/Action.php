<?php

/**
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\WorkflowNotification\Dca;

use NotificationCenter\Model\Notification;

/**
 * Class Action provides callbacks for tl_workflow_action.
 *
 * @package Netzmacht\Contao\WorkflowNotification\Dca
 */
class Action
{
    /**
     * Get notification ids.
     *
     * @return array
     */
    public function getNotificationIds()
    {
        $notifications = array();
        $collection    = Notification::findBy(array('type LIKE ?'), 'workflow_%');

        if ($collection) {
            foreach ($collection as $notification) {
                $notifications[$notification->type][$notification->id] = $notification->title;
            }
        }

        return $notifications;
    }

    public function getNotificationLanguages()
    {

    }
}
