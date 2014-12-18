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

use Netzmacht\Contao\WorkflowNotification\Event\PrepareNotificationTokensEvent;
use Netzmacht\Contao\WorkflowNotification\NotificationAction;
use Netzmacht\Workflow\Contao\Backend\Event\GetWorkflowActionsEvent;
use Netzmacht\Workflow\Contao\Definition\Event\CreateActionEvent;
use Netzmacht\Workflow\Contao\ServiceContainerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Workflow Subscriber integrates notification addon into the workflow environment.
 *
 * @package Netzmacht\Contao\WorkflowNotification\Subscriber
 */
class WorkflowSubscriber implements EventSubscriberInterface
{
    use ServiceContainerTrait;

    /**
     * Contao user.
     *
     * @var \User
     */
    private $user;

    /**
     * Date format.
     *
     * @var string
     */
    private $dateFormat;

    /**
     * Construct.
     *
     * @param \User  $user       Contao user.
     * @param string $dateFormat Used date format.
     */
    function __construct($user, $dateFormat = DATE_RFC822)
    {
        $this->user       = $user;
        $this->dateFormat = $dateFormat;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            GetWorkflowActionsEvent::NAME        => 'register',
            CreateActionEvent::NAME              => 'createAction',
            PrepareNotificationTokensEvent::NAME => 'prepareTokens'
        );
    }

    /**
     * Register notification action.
     *
     * @param GetWorkflowActionsEvent $event Subscribed event.
     */
    public function register(GetWorkflowActionsEvent $event)
    {
        $event->addAction('workflow', 'workflow_notification');
    }

    /**
     * Create notification action.
     *
     * @param CreateActionEvent $event
     */
    public function createAction(CreateActionEvent $event)
    {
        $config = $event->getConfig();

        if ($config->type === 'workflow_notification') {
            $action = new NotificationAction(
                $this->getService('event-dispatcher'),
                $this->getService('workflow.notification.queue'),
                $config->notification_id,
                $config->notification_language
            );

            $event->setAction($action);
        }
    }

    /**
     * Prepare notification tokens.
     *
     * @param PrepareNotificationTokensEvent $event
     */
    public function prepareTokens(PrepareNotificationTokensEvent $event)
    {
        $tokens = $event->getTokens();

        $tokens['user'] = array(
            'id'       => $this->user->id,
            'username' => $this->user->username,
            'email'    => $this->user->email,
        );

        $tokens['date'] = date($this->dateFormat);
    }
}
