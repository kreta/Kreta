<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Repository;

use Doctrine\ORM\EntityRepository;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class ProjectRoleRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class ProjectRoleRepository extends EntityRepository
{
    /**
     * Finds the role of project and user given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface    $user    The user
     *
     * @return string
     */
    public function findOneByProjectAndUser(ProjectInterface $project, UserInterface $user)
    {
        $queryBuilder = $this->createQueryBuilder('pr');

        return $queryBuilder->select('pr.role')
            ->where($queryBuilder->expr()->eq('pr.project', ':project'))
            ->andWhere($queryBuilder->expr()->eq('pr.user', ':user'))
            ->setParameters(array(':project' => $project->getId(), ':user' => $user->getId()))
            ->getQuery()->getArrayResult();
    }
}
