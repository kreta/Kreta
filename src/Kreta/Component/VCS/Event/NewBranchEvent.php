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
 * Class NewBranchEvent.
 *
 * @package Kreta\Component\VCS\Event
 */
class NewBranchEvent extends Event
{
    const NAME = 'kreta_vcs.event.branch.new';

    /**
     * The branch.
     *
     * @var \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    protected $branch;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\BranchInterface $branch The branch
     */
    public function __construct(BranchInterface $branch)
    {
        $this->branch = $branch;
    }

    /**
     * Gets just created branch.
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    public function getBranch()
    {
        return $this->branch;
    }
}
