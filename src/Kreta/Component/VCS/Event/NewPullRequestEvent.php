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

use Kreta\Component\VCS\Model\PullRequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewPullRequestEvent
 *
 * @package Kreta\Component\VCS\Event
 */
class NewPullRequestEvent extends Event
{
    /**
     * @var PullRequestInterface
     */
    protected $pullRequest;

    /**
     * @param PullRequestInterface $pullRequest
     */
    public function __construct(PullRequestInterface $pullRequest)
    {
        $this->pullRequest = $pullRequest;
    }

    /**
     * Gets the pull request.
     *
     * @return PullRequestInterface
     */
    public function getPullRequest()
    {
        return $this->pullRequest;
    }
} 
