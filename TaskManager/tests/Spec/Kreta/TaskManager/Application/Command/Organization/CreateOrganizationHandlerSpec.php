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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationCommand;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationHandler;
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
    private $organizationId;
    private $slug;
    private $creatorId;

    function let(
        OrganizationRepository $repository,
        UserRepository $userRepository,
        CreateOrganizationCommand $command
    ) {
        $this->beConstructedWith($repository, $userRepository);

        $command->name()->shouldBeCalled()->willReturn('organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $command->creatorId()->shouldBeCalled()->willReturn('user-id');

        $this->organizationId = OrganizationId::generate('organization-id');
        $this->slug = new Slug('organization-slug');
        $this->creatorId = UserId::generate('user-id');
    }

    function it_creates_an_organization(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $this->shouldHaveType(CreateOrganizationHandler::class);

        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn(null);
        $userRepository->userOfId($this->creatorId)->shouldBeCalled()->willReturn($user);
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_creates_an_organization_without_slug(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $command->slug()->shouldBeCalled()->willReturn(null);
        $slug = new Slug('organization name');

        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $repository->organizationOfSlug($slug)->shouldBeCalled()->willReturn(null);
        $userRepository->userOfId($this->creatorId)->shouldBeCalled()->willReturn($user);
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_create_an_organization_because_already_exists_an_organization_with_id(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $this->shouldThrow(OrganizationAlreadyExistsException::class)->during__invoke($command);
    }

    function it_does_not_create_an_organization_because_already_exists_an_organization_with_slug(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn($organization);
        $this->shouldThrow(OrganizationAlreadyExistsException::class)->during__invoke($command);
    }

    function it_does_not_create_an_organization_because_creator_does_not_exist(
        CreateOrganizationCommand $command,
        OrganizationRepository $repository,
        UserRepository $userRepository
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn(null);
        $userRepository->userOfId(Argument::type(UserId::class))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }
}
