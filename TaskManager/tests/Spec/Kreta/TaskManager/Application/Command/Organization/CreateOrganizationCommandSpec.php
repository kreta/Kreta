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

namespace Spec\Kreta\TaskManager\Application\Command\Organization;

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationCommand;
use PhpSpec\ObjectBehavior;

class CreateOrganizationCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith('creator-id', 'Organization name');
        $this->shouldHaveType(CreateOrganizationCommand::class);
        $this->id()->shouldReturn(null);
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn(null);
        $this->creatorId()->shouldReturn('creator-id');
    }

    function it_can_be_created_with_basic_info_and_organization_id()
    {
        $this->beConstructedWith('creator-id', 'Organization name', 'organization-id');
        $this->shouldHaveType(CreateOrganizationCommand::class);
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn(null);
        $this->creatorId()->shouldReturn('creator-id');
    }

    function it_can_be_created_with_basic_info_organization_id_creator_id()
    {
        $this->beConstructedWith(
            'creator-id',
            'Organization name',
            'organization-id'
        );
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn(null);
        $this->creatorId()->shouldReturn('creator-id');
    }

    function it_can_be_created_with_basic_info_organization_id_creator_id_and_slug()
    {
        $this->beConstructedWith(
            'creator-id',
            'Organization name',
            'organization-id',
            'organization-slug'
        );
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn('organization-slug');
    }

    function it_cannot_be_created_with_empty_user_id()
    {
        $this->beConstructedWith('', 'Organization name');
        $this->shouldThrow(new InvalidArgumentException('User id cannot be null'))->duringInstantiation();
    }
}
