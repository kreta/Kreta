<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\EventListener;

use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Matcher\CommitMatcher;
use Kreta\Component\VCS\Repository\CommitRepository;

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
     * The commit repository.
     *
     * @var \Kreta\Component\VCS\Repository\CommitRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Matcher\CommitMatcher       $matcher          The commit matcher
     * @param \Kreta\Component\VCS\Repository\CommitRepository $commitRepository The commit repository
     */
    public function __construct(CommitMatcher $matcher, CommitRepository $commitRepository)
    {
        $this->matcher = $matcher;
        $this->repository = $commitRepository;
    }

    /**
     * Fills the commit with related issues matched by CommitMatcher.
     *
     * @param \Kreta\Component\VCS\Event\NewCommitEvent $event The new commit event
     *
     * @return void
     */
    public function newCommit(NewCommitEvent $event)
    {
        $commit = $event->getCommit();

        $related = $this->matcher->getRelatedIssues($commit);
        $commit->setIssuesRelated($related);

        $this->repository->persist($commit);
    }
}
