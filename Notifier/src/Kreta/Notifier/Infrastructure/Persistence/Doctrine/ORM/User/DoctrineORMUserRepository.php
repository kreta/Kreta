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

namespace Kreta\Notifier\Infrastructure\Persistence\Doctrine\ORM\User;

use Doctrine\ORM\EntityRepository;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;

class DoctrineORMUserRepository extends EntityRepository implements UserRepository
{
    public function userOfId(UserId $id)
    {
        return $this->find($id->id());
    }

    public function persist(User $user)
    {
        $this->getEntityManager()->persist($user);
    }
}
