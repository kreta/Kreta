<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Matcher\Interfaces;

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;

/**
 * Interface IssueMatcherInterface
 *
 * @package Kreta\Component\VCS\Matcher\Interfaces
 */
interface IssueMatcherInterface
{
    /**
     * @param CommitInterface $commit
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getRelatedIssues(CommitInterface $commit);
} 
