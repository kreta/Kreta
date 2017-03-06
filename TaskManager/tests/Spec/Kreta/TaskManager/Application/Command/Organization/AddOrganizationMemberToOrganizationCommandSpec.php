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

namespace Spec\Kreta\TaskManager\Application\Command\Organization;

use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationCommand;
use PhpSpec\ObjectBehavior;

class AddOrganizationMemberToOrganizationCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith('user-id', 'organization-id', 'adder-id');
        $this->shouldHaveType(AddOrganizationMemberToOrganizationCommand::class);
        $this->adderId()->shouldReturn('adder-id');
        $this->userId()->shouldReturn('user-id');
        $this->organizationId()->shouldReturn('organization-id');
    }
}
