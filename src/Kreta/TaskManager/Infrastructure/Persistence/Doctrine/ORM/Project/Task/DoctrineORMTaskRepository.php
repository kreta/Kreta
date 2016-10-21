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

namespace Kreta\TaskManager\Infrastructure\Persistence\ORM\Organization;

use Doctrine\ORM\EntityRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;

class DoctrineORMTaskRepository extends EntityRepository implements TaskRepository
{
    public function taskOfId(TaskId $id)
    {
        return $this->find($id->id());
    }

    public function persist(Task $task)
    {
        $this->getEntityManager()->persist($task);
    }

    public function remove(Task $task)
    {
        $this->getEntityManager()->remove($task);
    }
}
