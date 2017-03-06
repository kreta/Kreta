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
use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddOrganizationMemberToOrganizationHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, UserRepository $userRepository)
    {
        $this->beConstructedWith($repository, $userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddOrganizationMemberToOrganizationHandler::class);
    }

    function it_adds_organization_member_to_organization(
        AddOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        Organization $organization,
        User $user
    ) {
        $command->adderId()->shouldBeCalled()->willReturn('adder-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');

        $userId = UserId::generate('user-id');
        $adderId = UserId::generate('adder-id');
        $organizationId = OrganizationId::generate('organization-id');

        $repository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOwner($adderId)->shouldBeCalled()->willReturn(true);
        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn($user);
        $organization->addOrganizationMember($userId)->shouldBeCalled();
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_add_organization_member_to_organization_because_user_does_not_exist(
        AddOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        Organization $organization
    ) {
        $command->adderId()->shouldBeCalled()->willReturn('adder-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');

        $userId = UserId::generate('user-id');
        $adderId = UserId::generate('adder-id');
        $organizationId = OrganizationId::generate('organization-id');

        $repository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOwner($adderId)->shouldBeCalled()->willReturn(true);
        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_add_organization_member_to_organization_because_organization_does_not_exist(
        AddOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository
    ) {
        $command->adderId()->shouldBeCalled()->willReturn('adder-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');

        $organizationId = OrganizationId::generate('organization-id');

        $repository->organizationOfId($organizationId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_add_organization_member_to_organization_because_it_is_not_allowed(
        AddOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $command->adderId()->shouldBeCalled()->willReturn('adder-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');

        $adderId = UserId::generate('adder-id');
        $organizationId = OrganizationId::generate('organization-id');

        $repository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOwner($adderId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedOrganizationActionException::class)->during__invoke($command);
    }
}
