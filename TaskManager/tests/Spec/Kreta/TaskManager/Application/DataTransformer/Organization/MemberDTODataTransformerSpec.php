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
use Kreta\TaskManager\Application\DataTransformer\Organization\MemberDTODataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMember;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class MemberDTODataTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MemberDTODataTransformer::class);
        $this->shouldImplement(MemberDataTransformer::class);
    }

    function it_transform_member_to_plain_dto()
    {
        $userId = UserId::generate('user-id');
        $organization = new Organization(
            OrganizationId::generate('organization-id'),
            new OrganizationName('Organization name'),
            new Slug('Organization name'),
            $userId
        );
        $member = new OrganizationMember(
            OrganizationMemberId::generate('member-id'),
            $userId,
            $organization
        );

        $this->write($member);
        $this->read()->shouldReturn([
            'id'           => 'member-id',
            'created_on'   => (new \DateTimeImmutable())->format('Y-m-d'),
            'updated_on'   => (new \DateTimeImmutable())->format('Y-m-d'),
            'user_id'      => 'user-id',
            'organization' => [
                [
                    'id'         => 'organization-id',
                    'name'       => 'Organization name',
                    'slug'       => 'organization-name',
                    'created_on' => (new \DateTimeImmutable())->format('Y-m-d'),
                    'updated_on' => (new \DateTimeImmutable())->format('Y-m-d'),
                ],
            ],
        ]);
    }

    function it_does_not_transformer_when_member_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}
