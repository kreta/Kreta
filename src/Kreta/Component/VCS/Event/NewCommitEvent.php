<?php

/*
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
 * Class NewCommitEvent.
 *
 * @package Kreta\Component\VCS\Event
 */
class NewCommitEvent extends Event
{
    const NAME = 'kreta_vcs.event.commit.new';

    /**
     * The commit.
     *
     * @var \Kreta\Component\VCS\Model\Interfaces\CommitInterface
     */
    protected $commit;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\CommitInterface $commit The commit
     */
    public function __construct(CommitInterface $commit)
    {
        $this->commit = $commit;
    }

    /**
     * Gets just created commit.
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\CommitInterface
     */
    public function getCommit()
    {
        return $this->commit;
    }
}
