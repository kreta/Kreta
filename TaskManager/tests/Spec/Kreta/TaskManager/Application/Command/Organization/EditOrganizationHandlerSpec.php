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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\Command\Organization\EditOrganizationCommand;
use Kreta\TaskManager\Application\Command\Organization\EditOrganizationHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedEditOrganizationException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditOrganizationHandlerSpec extends ObjectBehavior
{
    private $slug;
    private $name;
    private $organizationId;
    private $editorId;

    function let(OrganizationRepository $repository, EditOrganizationCommand $command)
    {
        $this->beConstructedWith($repository);

        $command->name()->shouldBeCalled()->willReturn('Organization name');
        $command->slug()->shouldBeCalled()->willReturn('organization-slug');
        $command->id()->shouldBeCalled()->willReturn('organization-id');
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');

        $this->slug = new Slug('organization-slug');
        $this->name = new OrganizationName('Organization name');
        $this->organizationId = OrganizationId::generate('organization-id');
        $this->editorId = UserId::generate('editor-id');
    }

    function it_edits_an_organization(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $this->shouldHaveType(EditOrganizationHandler::class);

        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn(null);
        $organization->isOwner($this->editorId)->shouldBeCalled()->willReturn(true);
        $organization->edit($this->name, $this->slug)->shouldBeCalled();
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_edits_an_organization_without_slug(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $command->slug()->shouldBeCalled()->willReturn(null);
        $slug = new Slug('Organization name');

        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->organizationOfSlug($slug)->shouldBeCalled()->willReturn(null);
        $organization->isOwner($this->editorId)->shouldBeCalled()->willReturn(true);
        $organization->edit($this->name, $slug)->shouldBeCalled();
        $repository->persist(Argument::type(Organization::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_edits_an_organization_because_the_organization_does_not_exist(
        EditOrganizationCommand $command,
        OrganizationRepository $repository
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_edits_an_organization_because_the_organization_slug_already_exists(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization,
        Organization $organization2
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn($organization2);
        $this->shouldThrow(OrganizationAlreadyExistsException::class)->during__invoke($command);
    }

    function it_does_not_edits_an_organization_because_the_owner_does_not_authorized(
        EditOrganizationCommand $command,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $repository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->organizationOfSlug($this->slug)->shouldBeCalled()->willReturn(null);
        $organization->isOwner($this->editorId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedEditOrganizationException::class)->during__invoke($command);
    }
}
