<?php

/**
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\WorkflowNotification\Event;

use Netzmacht\Workflow\Contao\Backend\Dca\Transition;
use Netzmacht\Workflow\Flow\Item;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event is emitted when notification tokens are prepared.
 *
 * @package Netzmacht\Contao\WorkflowNotification\Event
 */
class PrepareNotificationTokensEvent extends Event
{
    const NAME = 'workflow.notification.prepare-tokens';

    /**
     * Notifciation tokens.
     *
     * @var \ArrayObject
     */
    private $tokens;

    /**
     * Workflow transition.
     *
     * @var Transition
     */
    private $transition;

    /**
     * Workflow item.
     *
     * @var Item
     */
    private $item;

    /**
     * Construct.
     *
     * @param \ArrayObject $tokens     Notifciation tokens.
     * @param Transition   $transition Workflow transition.
     * @param Item         $item       Workflow item.
     */
    function __construct(\ArrayObject $tokens, Transition $transition, Item $item)
    {
        $this->tokens     = $tokens;
        $this->transition = $transition;
        $this->item       = $item;
    }

    /**
     * Get Notifciation tokens.
     *
     * @return \ArrayObject
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Get current transition.
     *
     * @return Transition
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * Get workflow item.
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
