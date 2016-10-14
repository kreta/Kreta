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

use Kreta\TaskManager\Application\Organization\CreateOrganizationCommand;
use Kreta\TaskManager\Application\Organization\CreateOrganizationHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateOrganizationHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, UserRepository $userRepository)
    {
        $this->beConstructedWith($repository, $userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrganizationHandler::class);
    }

    function it_creates_an_organization(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $userId = UserId::generate('user-id');
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn(null);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn($user);
        $user->id()->shouldBeCalled()->willReturn($userId);
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_creates_an_organization_without_organization_id(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $userId = UserId::generate('user-id');
        $command->id()->shouldBeCalled()->willReturn(null);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn($user);
        $user->id()->shouldBeCalled()->willReturn($userId);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_creates_an_organization_without_slug(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $userId = UserId::generate('user-id');
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn(null);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn($user);
        $user->id()->shouldBeCalled()->willReturn($userId);
        $repository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn(null);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn(null);
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_create_an_organization_because_already_exists_an_organization_with_id(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))
            ->shouldBeCalled()->willReturn($organization);
        $this->shouldThrow(OrganizationAlreadyExistsException::class)->during__invoke($command);
    }

    function it_does_not_create_an_organization_because_user_does_not_exist(
        CreateOrganizationCommand $command,
        UserRepository $userRepository
    ) {
        $command->id()->shouldBeCalled()->willReturn(null);
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');
        $userRepository->userOfId(Argument::type(UserId::class))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }
}
