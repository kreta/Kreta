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

namespace Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\User\UserId;

class MemberId
{
    protected $userId;
    protected $organizationId;

    public static function generate(UserId $userId, OrganizationId $organizationId)
    {
        return new static($userId, $organizationId);
    }

    protected function __construct(UserId $userId, OrganizationId $organizationId)
    {
        $this->userId = $userId;
        $this->organizationId = $organizationId;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function organizationId()
    {
        return $this->organizationId;
    }

    public function equals(MemberId $id) : bool
    {
        return $this->organizationId === $id->organizationId() && $this->userId->id() === $id->userId()->id();
    }

    public function __toString() : string
    {
        return 'UserId: ' . (string) $this->userId->id() . ', OrganizationId: ' . (string) $this->organizationId()->id();
    }
}
