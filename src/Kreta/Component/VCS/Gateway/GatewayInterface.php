<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Gateway;

use Kreta\Component\VCS\Model\BranchInterface;
use Kreta\Component\VCS\Model\PullRequestInterface;

interface GatewayInterface
{
    /**
     * Creates a branch in the VCS provider
     *
     * @param \Kreta\Component\VCS\Model\BranchInterface $branch
     *
     * @return mixed
     */
    public function createBranch(BranchInterface $branchName);

    /**
     * Creates a pull request in the VCS provider
     *
     * @param PullRequestInterface $pullRequest
     *
     * @return mixed
     */
    public function createPullRequest(PullRequestInterface $pullRequest);
}
