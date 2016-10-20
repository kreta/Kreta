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

use Kreta\SharedKernel\Domain\Model\Collection;
use Kreta\SharedKernel\Domain\Model\InvalidCollectionElementException;
use Kreta\TaskManager\Domain\Model\User\UserId;

abstract class MemberCollection extends Collection
{
    public function containsUserId(UserId $userId)
    {
        $members = $this->toArray();
        foreach ($members as $member) {
            if ($userId->equals($member->userId())) {
                return true;
            }
        }

        return false;
    }

    public function removeByUserId(UserId $userId)
    {
        $members = $this->toArray();
        foreach ($members as $member) {
            if ($userId->equals($member->userId())) {
                $this->remove($member);
                return;
            }
        }

        throw new InvalidCollectionElementException();
    }
}
