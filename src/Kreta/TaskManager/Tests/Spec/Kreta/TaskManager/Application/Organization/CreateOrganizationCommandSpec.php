<?php

namespace Spec\Kreta\TaskManager\Application\Organization;

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use Kreta\TaskManager\Application\Organization\CreateOrganizationCommand;
use PhpSpec\ObjectBehavior;

class CreateOrganizationCommandSpec extends ObjectBehavior
{
    function it_builds()
    {
        $this->beConstructedWith('owner-id', 'user-id', 'Organization name');
        $this->shouldHaveType(CreateOrganizationCommand::class);
        $this->id()->shouldReturn(null);
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn(null);
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
    }

    function it_builds_with_id()
    {
        $this->beConstructedWith('owner-id', 'user-id', 'Organization name', 'organization-id');
        $this->shouldHaveType(CreateOrganizationCommand::class);
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn(null);
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
    }

    function it_builds_with_slug()
    {
        $this->beConstructedWith('owner-id', 'user-id', 'Organization name', 'organization-id', 'organization-slug');
        $this->id()->shouldReturn('organization-id');
        $this->name()->shouldReturn('Organization name');
        $this->slug()->shouldReturn('organization-slug');
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
    }

    function it_builds_without_owner_id()
    {
        $this->beConstructedWith('', 'user-id', 'Organization name');
        $this->shouldThrow(new InvalidArgumentException('Owner id cannot be null'))->duringInstantiation();
    }

    function it_builds_without_user_id()
    {
        $this->beConstructedWith('owner-id', '', 'Organization name');
        $this->shouldThrow(new InvalidArgumentException('User id cannot be null'))->duringInstantiation();
    }

    function it_builds_without_organization_name()
    {
        $this->beConstructedWith('owner-id', 'user-id', '');
        $this->shouldThrow(new InvalidArgumentException('Organization name cannot be null'))->duringInstantiation();
    }
}
