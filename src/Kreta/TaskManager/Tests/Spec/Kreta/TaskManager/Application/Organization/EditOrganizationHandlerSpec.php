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
use Kreta\TaskManager\Application\Organization\EditOrganizationHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditOrganizationHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, UserRepository $userRepository)
    {
        $this->beConstructedWith($repository, $userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditOrganizationHandler::class);
    }

    function it_edits_an_organization(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn($organization);
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_edits_an_organization_without_slug(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn($organization);
        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn(null);
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_edits_an_organization_because_the_organization_does_not_exist(
        EditOrganizationCommand $command,
        OrganizationRepository $repository
    ) {
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(Argument::type(OrganizationId::class))
            ->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($command);
    }
}
