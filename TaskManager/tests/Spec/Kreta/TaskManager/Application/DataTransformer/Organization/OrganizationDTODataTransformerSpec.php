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

    function it_transform_organization_to_plain_dto(MemberDataTransformer $memberDataTransformer)
    {
        $userId = UserId::generate('user-id');

        $organization = new Organization(
            OrganizationId::generate('organization-id'),
            new OrganizationName('Organization name'),
            new Slug('Organization name'),
            $userId
        );

        $this->write($organization);

        $memberDataTransformer->write($organization->owner($userId))->shouldBeCalled();
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

        $this->read()->shouldReturn([
            'id'                  => 'organization-id',
            'name'                => 'Organization name',
            'slug'                => 'organization-name',
            'created_on'          => (new \DateTimeImmutable())->format('Y-m-d'),
            'updated_on'          => (new \DateTimeImmutable())->format('Y-m-d'),
            'owners'              => [[
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
            ]],
            'organization_members' => [],
        ]);
    }

    function it_does_not_transformer_when_organization_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}
