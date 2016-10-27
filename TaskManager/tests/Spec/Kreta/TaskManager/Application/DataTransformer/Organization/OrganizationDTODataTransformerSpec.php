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

namespace Spec\Kreta\TaskManager\Application\DataTransformer\Organization;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Organization\MemberDataTransformer;
use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDataTransformer;
use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDTODataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OrganizationDTODataTransformerSpec extends ObjectBehavior
{
    function let(MemberDataTransformer $memberDataTransformer)
    {
        $this->beConstructedWith($memberDataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationDTODataTransformer::class);
        $this->shouldImplement(OrganizationDataTransformer::class);
    }

    function it_transform_organization_to_plain_dto(
        Organization $organization,
        OrganizationId $organizationId,
        OrganizationName $organizationName,
        Slug $slug,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $updatedOn,
        Owner $owner,
        MemberDataTransformer $memberDataTransformer,
        OwnerId $ownerId,
        UserId $userId
    ) {
        $this->write($organization);

        $organization->owners()->shouldReturnCollection([$owner]);
        $owner->id()->shouldBeCalled()->willReturn($ownerId);
        $owner->id()->shouldBeCalled()->willReturn('owner-id');
        $createdOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');
        $updatedOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');
        $owner->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $owner->organization()->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organizationId->id()->shouldBeCalled()->willReturn('organization-id');
        $organization->name()->shouldBeCalled()->willReturn($organizationName);
        $organizationName->name()->shouldBeCalled()->willReturn('Organization name');
        $organization->slug()->shouldBeCalled()->willReturn($slug);
        $slug->slug()->shouldBeCalled()->willReturn('organization-name');
        $organization->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $organization->updatedOn()->shouldBeCalled()->willReturn($updatedOn);
        $createdOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');
        $updatedOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');
        $memberDataTransformer->read()->shouldBeCalled()->willReturn([
            'id'           => 'owner-id',
            'created_on'   => '2016-10-24',
            'updated_on'   => '2016-10-24',
            'user_id'      => 'user-id',
            'organization' => [
                [
                    'id'         => 'organization-id',
                    'name'       => 'Organization name',
                    'slug'       => 'organization-name',
                    'created_on' => '2016-10-24',
                    'updated_on' => '2016-10-24',
                ],
            ],
        ]);
        $organization->organizationMembers()->shouldBeCalled()->willReturn([]);

        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organizationId->id()->shouldBeCalled()->willReturn('organization-id');
        $organization->name()->shouldBeCalled()->willReturn($organizationName);
        $organizationName->name()->shouldBeCalled()->willReturn('Organization name');
        $organization->slug()->shouldBeCalled()->willReturn($slug);
        $slug->slug()->shouldBeCalled()->willReturn('organization-name');
        $organization->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $organization->updatedOn()->shouldBeCalled()->willReturn($updatedOn);
        $createdOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');
        $updatedOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-24');

        $this->read()->shouldReturn([
            'id'                  => 'organization-id',
            'name'                => 'Organization name',
            'slug'                => 'organization-name',
            'created_on'          => '2016-10-24',
            'updated_on'          => '2016-10-24',
            'owners'              => [],
            'organizationMembers' => [],
        ]);
    }

    function it_does_not_transformer_when_organization_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}
