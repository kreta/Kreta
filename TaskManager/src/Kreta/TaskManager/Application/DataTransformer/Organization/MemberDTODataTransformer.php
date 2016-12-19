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

namespace Kreta\TaskManager\Application\DataTransformer\Organization;

use Kreta\TaskManager\Domain\Model\Organization\Member;

class MemberDTODataTransformer implements MemberDataTransformer
{
    private $member;

    public function write(Member $member)
    {
        $this->member = $member;
    }

    public function read()
    {
        if (!$this->member instanceof Member) {
            return [];
        }

        return [
            'id'           => $this->member->userId()->id(),
            'created_on'   => $this->member->createdOn()->format('Y-m-d'),
            'updated_on'   => $this->member->updatedOn()->format('Y-m-d'),
            'organization' => [
                'id'         => $this->member->organization()->id()->id(),
                'name'       => $this->member->organization()->name()->name(),
                'slug'       => $this->member->organization()->slug()->slug(),
                'created_on' => $this->member->organization()->createdOn()->format('Y-m-d'),
                'updated_on' => $this->member->organization()->updatedOn()->format('Y-m-d'),
            ],
        ];
    }
}
