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

namespace Spec\Kreta\TaskManager\Application\Organization;

use Kreta\TaskManager\Application\Organization\AddOwnerToOrganizationCommand;
use PhpSpec\ObjectBehavior;

class AddOwnerToOrganizationCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith('adder-id', 'user-id', 'organization-id');
        $this->shouldHaveType(AddOwnerToOrganizationCommand::class);
        $this->adderId()->shouldReturn('adder-id');
        $this->userId()->shouldReturn('user-id');
        $this->organizationId()->shouldReturn('organization-id');
    }
}
