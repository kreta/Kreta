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

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewCommitsEvent
 *
 * @package Kreta\Component\VCS\Event
 */
class NewCommitsEvent extends Event
{
    /**
     * @var CommitInterface
     */
    protected $commits;

    /**
     * @param CommitInterface[] $commits
     */
    public function __construct(array $commits)
    {
        $this->commits = $commits;
    }

    /**
     * Gets the commits.
     *
     * @return CommitInterface[]
     */
    public function getCommits()
    {
        return $this->commits;
    }
} 
