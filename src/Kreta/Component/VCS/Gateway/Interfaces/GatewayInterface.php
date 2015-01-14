<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Gateway\Interfaces;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\PullRequestInterface;

/**
 * Interface GatewayInterface.
 *
 * @package Kreta\Component\VCS\Gateway\Interfaces
 */
interface GatewayInterface
{
    /**
     * Creates a branch in the VCS provider.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\BranchInterface $branch The branch
     *
     * @return mixed
     */
    public function createBranch(BranchInterface $branch);

    /**
     * Creates a pull request in the VCS provider
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\PullRequestInterface $pullRequest The pull request
     *
     * @return mixed
     */
    public function createPullRequest(PullRequestInterface $pullRequest);
}
