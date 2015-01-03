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
use Kreta\Component\VCS\Event\NewBranchEvent;
use Kreta\Component\VCS\Matcher\BranchMatcher;

/**
 * Class BranchListener
 *
 * @package Kreta\Component\VCS\EventListener
 */
class BranchListener
{
    /** @var BranchMatcher $matcher */
    protected $matcher;

    /** @var EntityManager $manager */
    protected $manager;

    /**
     * Constructor.
     *
     * @param BranchMatcher $matcher
     * @param EntityManager $manager
     */
    public function __construct(BranchMatcher $matcher, EntityManager $manager)
    {
        $this->matcher = $matcher;
        $this->manager = $manager;
    }

    /**
     * Fills the branch with related issues matched by BranchMatcher
     *
     * @param NewBranchEvent $event
     */
    public function newBranch(NewBranchEvent $event)
    {
        $branch = $event->getBranch();

        $related = $this->matcher->getRelatedIssues($branch);
        $branch->setIssuesRelated($related);

        $this->manager->persist($branch);
        $this->manager->flush();
    }
}
