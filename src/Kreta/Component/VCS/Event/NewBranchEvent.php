<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Event;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewBranchEvent
 *
 * @package Kreta\Component\VCS\Event
 */
class NewBranchEvent extends Event
{
    const NAME = 'kreta_vcs.event.branch.new';

    /** @var BranchInterface */
    protected $branch;

    /**
     * Creates new commit event.
     *
     * @param BranchInterface $branch
     */
    public function __construct(BranchInterface $branch)
    {
        $this->branch = $branch;
    }

    /**
     * Gets just created branch.
     *
     * @return BranchInterface
     */
    public function getBranch()
    {
        return $this->branch;
    }
} 
