<?php

namespace Spec\Kreta\TaskManager\Application\Organization;

use Kreta\TaskManager\Application\Organization\CreateOrganizationCommand;
use Kreta\TaskManager\Application\Organization\CreateOrganizationHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Organization\OwnerRepository;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateOrganizationHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, OwnerRepository $ownerRepository)
    {
        $this->beConstructedWith($repository, $ownerRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrganizationHandler::class);
    }

    function it_creates_an_organization(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        OwnerRepository $ownerRepository,
        Owner $owner
    ) {
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $command->ownerId()->shouldBeCalled()->willReturn('owner-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $ownerRepository->ownerOfId(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn($owner);
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_create_an_organization_because_owner_does_not_exist(
        CreateOrganizationCommand $command,
        OwnerRepository $ownerRepository
    ) {
        $command->ownerId()->shouldBeCalled()->willReturn('owner-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $ownerRepository->ownerOfId(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OwnerDoesNotExistException::class)->during__invoke($command);
    }
}
