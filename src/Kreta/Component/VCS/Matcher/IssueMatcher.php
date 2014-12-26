<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Matcher;

use Kreta\Component\VCS\Matcher\Interfaces\IssueMatcherInterface;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;

class IssueMatcher implements IssueMatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRelatedIssues(CommitInterface $commit)
    {
        return [];
    }
}
