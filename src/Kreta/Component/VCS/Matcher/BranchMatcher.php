<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Matcher;

use Kreta\Component\VCS\Matcher\Abstracts\AbstractMatcher;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;

/**
 * Class BranchMatcher.
 *
 * @package Kreta\Component\VCS\Matcher
 */
class BranchMatcher extends AbstractMatcher
{
    /**
     * {@inheritdoc}
     */
    public function getRelatedIssues($branch)
    {
        if (!$branch instanceof BranchInterface) {
            return [];
        }

        return $this->findRelatedIssues($branch->getRepository(), $branch->getName());
    }
}
