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

namespace Kreta\TaskManager\Infrastructure\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\User\UserId;

class DoctrineOwner extends Owner
{
    protected $surrogateUserId;
    protected $surrogateOrganizationId;

    public function __construct(OwnerId $id)
    {
        parent::__construct($id);
        $this->surrogateUserId = $id->userId()->id();
        $this->surrogateOrganizationId = $id->organizationId()->id();
    }

    public function id() : MemberId
    {
        return OwnerId::generate(
            UserId::generate($this->surrogateUserId),
            OrganizationId::generate($this->surrogateOrganizationId)
        );
    }
}
