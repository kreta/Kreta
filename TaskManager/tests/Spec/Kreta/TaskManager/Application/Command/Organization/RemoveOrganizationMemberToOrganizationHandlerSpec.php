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

use Kreta\TaskManager\Application\Command\Organization\RemoveOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMember;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveOrganizationMemberToOrganizationHandlerSpec extends ObjectBehavior
{
    private $organizationId;
    private $removerId;
    private $userId;

    function let(
        RemoveOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        TaskRepository $taskRepository,
        TaskSpecificationFactory $taskSpecificationFactory
    ) {
        $this->beConstructedWith($repository, $taskRepository, $taskSpecificationFactory);

        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $command->removerId()->shouldBeCalled()->willReturn('remover-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $this->organizationId = OrganizationId::generate('organization-id');
        $this->userId = UserId::generate('user-id');
        $this->removerId = UserId::generate('remover-id');
    }

    function it_does_not_remove_organization_member_to_organization_because_organization_does_not_exist(
        RemoveOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository
    ) {
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(OrganizationId::generate('organization-id'))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_remove_organization_member_to_organization_because_it_is_not_allowed(
        RemoveOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $command->removerId()->shouldBeCalled()->willReturn('remover-id');
        $organization->isOwner($this->removerId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedOrganizationActionException::class)->during__invoke($command);
    }

    function it_removes_organization_member_to_organization(
        RemoveOrganizationMemberToOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization,
        OrganizationMember $member,
        OrganizationMemberId $memberId,
        Owner $remover,
        OwnerId $removerId,
        TaskRepository $taskRepository,
        Task $task
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOwner($this->removerId)->shouldBeCalled()->willReturn(true);
        $organization->organizationMember($this->userId)->shouldBeCalled()->willReturn($member);
        $member->id()->shouldBeCalled()->willReturn($memberId);
        $organization->owner($this->removerId)->shouldBeCalled()->willReturn($remover);
        $remover->id()->shouldBeCalled()->willReturn($removerId);
        $taskRepository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);
        $organization->removeOrganizationMember($this->userId)->shouldBeCalled();
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }
}
