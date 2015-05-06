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

use Kreta\Component\VCS\Event\NewBranchEvent;
use Kreta\Component\VCS\Matcher\BranchMatcher;
use Kreta\Component\VCS\Repository\BranchRepository;

/**
 * Class BranchListener.
 *
 * @package Kreta\Component\VCS\EventListener
 */
class BranchListener
{
    /**
     * The branch matcher.
     *
     * @var \Kreta\Component\VCS\Matcher\BranchMatcher
     */
    protected $matcher;

    /**
     * The branch repository.
     *
     * @var \Kreta\Component\VCS\Repository\BranchRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Matcher\BranchMatcher       $matcher          The branch matcher
     * @param \Kreta\Component\VCS\Repository\BranchRepository $branchRepository The branch repository
     */
    public function __construct(BranchMatcher $matcher, BranchRepository $branchRepository)
    {
        $this->matcher = $matcher;
        $this->repository = $branchRepository;
    }

    /**
     * Fills the branch with related issues matched by BranchMatcher.
     *
     * @param \Kreta\Component\VCS\Event\NewBranchEvent $event The new branch event
     *
     * @return void
     */
    public function newBranch(NewBranchEvent $event)
    {
        $branch = $event->getBranch();

        $related = $this->matcher->getRelatedIssues($branch);
        $branch->setIssuesRelated($related);

        $this->repository->persist($branch);
    }
}
