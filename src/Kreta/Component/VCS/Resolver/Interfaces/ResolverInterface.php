<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Resolver\Interfaces;

/**
 * Interface ResolverInterface
 *
 * @package Kreta\Component\VCS\Resolver\Interfaces
 */
interface ResolverInterface
{
    /**
     * Transforms json message received from the provider into PullRequestInterface object
     *
     * @param string $json Message received
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\PullRequestInterface
     */
    public function getPullRequest($json);

    /**
     * Transforms json message received from the provider into CommitInterface array
     *
     * @param string $json Message received
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\CommitInterface[]
     */
    public function getCommits($json);
} 
