<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\VCS\Resolver\Interfaces\ResolverInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractWebhookStrategy
 *
 * @package Kreta\Component\VCS\Hooks
 */
abstract class AbstractWebhookStrategy
{
    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(ResolverInterface $resolver, EventDispatcher $eventDispatcher, ObjectManager $manager)
    {
        $this->resolver = $resolver;
        $this->eventDispatcher = $eventDispatcher;
        $this->manager = $manager;
    }

    /**
     * Parses the raw event and decides which handler has to be used.
     *
     * @param Request $request Received request from the webhook provider
     */
    abstract public function handleWebhook(Request $request);

    /**
     * Builds a Commit object and triggers an event to notify the hook reception.
     * Uses the ResolverInterface to create CommitInterface, persists it and triggers NewCommitEvent
     *
     * @param $event
     */
    abstract protected function handleCommit($event);

    /**
     * Builds a PullRequest object and triggers an event to notify the hook reception.
     * Uses the ResolverInterface to create PullRequestInterface, perists it and triggers NewPullRequestEvent
     *
     * @param $event
     */
    abstract protected function handlePullRequest($event);
} 
