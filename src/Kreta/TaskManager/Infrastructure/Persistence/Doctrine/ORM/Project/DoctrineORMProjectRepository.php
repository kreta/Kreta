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
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;

class DoctrineORMProjectRepository extends EntityRepository implements ProjectRepository
{
    public function projectOfId(ProjectId $id)
    {
        return $this->find($id->id());
    }

    public function persist(Project $project)
    {
        $this->getEntityManager()->persist($project);
    }

    public function remove(Project $project)
    {
        $this->getEntityManager()->remove($project);
    }
}
