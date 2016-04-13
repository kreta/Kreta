<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\OrganizationBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Behat Organization context class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationContext extends DefaultContext
{
    /**
     * Populates the database with organizations.
     *
     * @param \Behat\Gherkin\Node\TableNode $organizations The organizations
     *
     * @Given /^the following organizations exist:$/
     */
    public function theFollowingOrganizationsExist(TableNode $organizations)
    {
        foreach ($organizations as $organizationData) {
            $creator = $this->get('kreta_user.repository.user')
                ->findOneBy(['email' => $organizationData['creator']], false);
            $organization = $this->get('kreta_organization.factory.organization')
                ->create($organizationData['name'], $creator);
            if (isset($organizationData['id'])) {
                $this->setId($organization, $organizationData['id']);
            }

            $this->get('kreta_organization.repository.organization')->persist($organization);
        }
    }
}
