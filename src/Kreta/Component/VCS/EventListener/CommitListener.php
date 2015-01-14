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
 * Class CommitListener.
 *
 * @package Kreta\Component\VCS\EventListener
 */
class CommitListener
{
    /**
     * The commit matcher.
     *
     * @var \Kreta\Component\VCS\Matcher\CommitMatcher
     */
    protected $matcher;

    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Matcher\CommitMatcher $matcher The commit matcher
     * @param \Doctrine\ORM\EntityManager                $manager The entity manager
     */
    public function __construct(CommitMatcher $matcher, EntityManager $manager)
    {
        $this->matcher = $matcher;
        $this->manager = $manager;
    }

    /**
     * Fills the commit with related issues matched by CommitMatcher.
     *
     * @param \Kreta\Component\VCS\Event\NewCommitEvent $event The new commit event
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
