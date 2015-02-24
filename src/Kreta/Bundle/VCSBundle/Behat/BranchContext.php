<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class BranchContext.
 *
 * @package Kreta\Bundle\VCSBundle\Behat
 */
class BranchContext extends DefaultContext
{
    /**
     * Populates the database with branches.
     *
     * @param \Behat\Gherkin\Node\TableNode $branches The branches
     *
     * @return void
     *
     * @Given /^the following branches exist:$/
     */
    public function theFollowingBranchesExist(TableNode $branches)
    {
        foreach ($branches as $branchData) {
            $repository = $this->get('kreta_vcs.repository.repository')
                ->findOneBy(['name' => $branchData['repository']], false);
            $issuesRelated = [];
            if (isset($branchData['issuesRelated'])) {
                foreach (explode(',', $branchData['issuesRelated']) as $issueRelated) {
                    $issuesRelated[] = $this->get('kreta_issue.repository.issue')->find($issueRelated);
                }
            }

            $branch = $this->get('kreta_vcs.factory.branch')->create();
            $branch
                ->setName($branchData['name'])
                ->setRepository($repository);

            $this->setField($branch, 'issuesRelated', $issuesRelated);
            $this->setId($branch, $branchData['id']);

            $this->get('kreta_vcs.repository.branch')->persist($branch);
        }
    }
}
