<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Hooks;

use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class HookInterface
 *
 * @package Kreta\Component\VCS\Hooks
 */
abstract class WebhookStrategyInterface
{
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Parses the raw event and decides which event has to be triggered.
     *
     * @param array $event Decoded json array with event response
     */
    abstract public function handleWebhook($event);

    /**
     * Builds a Commit object and triggers an event to notify the hook reception.
     * Uses the CommitFactoryInterface custom implementation and NewCommitEvent
     *
     * @param $event
     */
    abstract protected function handleCommit($event);

    /**
     * Builds a PullRequest object and triggers an event to notify the hook reception.
     * Uses the PullRequestFactoryInterface custom implementation and NewCommitEvent
     *
     * @param $event
     */
    abstract protected function handlePullRequest($event);
} 
