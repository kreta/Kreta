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

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;

class CommitMatcher extends AbstractMatcher
{
    /**
     * {@inheritdoc}
     */
    public function getRelatedIssues($commit)
    {
        if (!$commit instanceof CommitInterface || !$commit->getBranch()) {
            return [];
        }

        return array_merge(
            $this->findRelatedIssues($commit->getBranch()->getRepository(), $commit->getMessage()),
            $this->findRelatedIssues($commit->getBranch()->getRepository(), $commit->getBranch()->getName())
        );
    }
}
