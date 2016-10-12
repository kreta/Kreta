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

namespace Kreta\TaskManager\Tests\Double\Domain\Model;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\Organization\Member;

class MemberStub extends Member
{
    public function __construct(OrganizationMemberId $id)
    {
        parent::__construct($id);
    }
}
