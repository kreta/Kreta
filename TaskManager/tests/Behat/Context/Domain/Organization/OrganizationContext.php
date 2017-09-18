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

declare(strict_types=1);

namespace Kreta\TaskManager\Tests\Behat\Context\Domain\Organization;

use Behat\Behat\Context\Context;

class OrganizationContext implements Context
{
    /**
     * @Given a :name name an organization was created
     */
    public function nameOrganizationWasCreated($name)
    {
    }

    /**
     * @When I create a organization with the given :name name
     */
    public function iCreateAnOrganizationWithTheGivenName($name)
    {
    }
}
