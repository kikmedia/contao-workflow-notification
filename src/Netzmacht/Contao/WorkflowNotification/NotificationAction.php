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

use Netzmacht\Contao\WorkflowNotification\Event\PrepareNotificationTokensEvent;
use Netzmacht\Workflow\Contao\Action\AbstractAction;
use Netzmacht\Workflow\Flow\Context;
use Netzmacht\Workflow\Flow\Item;
use Netzmacht\Workflow\Flow\Transition;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as EventDispatcher;

/**
 * Class NotificationAction creates an notification and adds it to the when transition is passed.
 *
 * @package Netzmacht\Contao\WorkflowNotification
 */
class NotificationAction extends AbstractAction
{
    /**
     * Notification queue.
     *
     * @var NotificationQueue
     */
    private $queue;

    /**
     * Notification id.
     *
     * @var int
     */
    private $notificationId;

    /**
     * Notification language.
     *
     * @var string
     */
    private $language;

    /**
     * Event dispatcher.
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * Construct.
     *
     * @param EventDispatcher   $eventDispatcher Event dispatcher.
     * @param NotificationQueue $queue           Notification queue.
     * @param int               $notificationId  Notification id.
     * @param string|null       $language        Optional requested language.
     */
    public function __construct(
        EventDispatcher $eventDispatcher,
        NotificationQueue $queue,
        $notificationId,
        $language = null
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->queue           = $queue;
        $this->notificationId  = $notificationId;
        $this->language        = $language;
    }

    /**
     * Get notification id.
     *
     * @return int
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * Set notification id.
     *
     * @param int $notificationId Notification id.
     *
     * @return $this
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the language.
     *
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transit(Transition $transition, Item $item, Context $context)
    {
        $data = $this->prepareData($transition, $item, $context);
        $this->queue->add($this->notificationId, $data, $this->language);
    }

    /**
     * Prepare data for the notification.
     *
     * @param Transition $transition Current transition.
     * @param Item       $item       Workflow item.
     * @param Context    $context    Transition context.
     *
     * @return array
     */
    private function prepareData(Transition $transition, Item $item, Context $context)
    {
        $entity = $this->getEntity($item);
        $step   = $transition->getStepTo();
        $tokens = array();

        $tokens['entity']  = $entity->getPropertiesAsArray();
        $tokens['context'] = $context->getProperties();

        $tokens['entityId'] = (string) $item->getEntityId();

        $tokens['transition']          = $transition->getConfig();
        $tokens['transition']['name']  = $transition->getName();
        $tokens['transition']['label'] = $transition->getLabel();

        $tokens['step']          = $step->getConfig();
        $tokens['step']['name']  = $step->getName();
        $tokens['step']['label'] = $step->getLabel();

        $event = new PrepareNotificationTokensEvent(new \ArrayObject($tokens), $transition, $item);
        $this->eventDispatcher->dispatch($event::NAME, $event);

        return $event->getTokens()->getArrayCopy();
    }
}
