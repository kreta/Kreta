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
 * Class NewCommitEvent
 *
 * @package Kreta\Component\VCS\Event
 */
class NewCommitEvent extends Event
{
    const NAME = 'kreta_vcs.event.commit.new';

    /** @var CommitInterface */
    protected $commit;

    /**
     * Creates new commit event.
     *
     * @param CommitInterface $commit
     */
    public function __construct(CommitInterface $commit)
    {
        $this->commit = $commit;
    }

    /**
     * Gets just created commit.
     *
     * @return CommitInterface
     */
    public function getCommit()
    {
        return $this->commit;
    }
} 
