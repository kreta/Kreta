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

use Kreta\TaskManager\Application\Organization\EditOrganizationCommand;
use PhpSpec\ObjectBehavior;

class EditOrganizationCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith('organization-id', 'Organization name', 'owner-id', 'user-id');
        $this->shouldHaveType(EditOrganizationCommand::class);
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
        $this->slug()->shouldReturn(null);
    }

    function it_can_be_created_with_basic_info_and_slug()
    {
        $this->beConstructedWith('organization-id', 'Organization name', 'owner-id', 'user-id', 'organization-slug');
        $this->shouldHaveType(EditOrganizationCommand::class);
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
        $this->slug()->shouldReturn('organization-slug');
    }
}
