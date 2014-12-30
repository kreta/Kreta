<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\EventListener;

use Doctrine\ORM\EntityManager;
use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Matcher\CommitMatcher;

/**
 * Class CommitListener
 *
 * @package Kreta\Component\VCS\EventListener
 */
class CommitListener
{
    /** @var CommitMatcher $matcher */
    protected $matcher;

    /** @var EntityManager $manager */
    protected $manager;

    /**
     * Constructor.
     *
     * @param CommitMatcher $matcher
     * @param EntityManager $manager
     */
    public function __construct(CommitMatcher $matcher, EntityManager $manager)
    {
        $this->matcher = $matcher;
        $this->manager = $manager;
    }

    /**
     * Fills the commit with related issues matched by CommitMatcher
     *
     * @param NewCommitEvent $event
     */
    public function newCommit(NewCommitEvent $event)
    {
        $commit = $event->getCommit();

        $related = $this->matcher->getRelatedIssues($commit);
        $commit->setIssuesRelated($related);

        $this->manager->persist($commit);
        $this->manager->flush();
    }
}
