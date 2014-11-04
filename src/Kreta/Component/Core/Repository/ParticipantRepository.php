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
 * Class ParticipantRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class ParticipantRepository extends EntityRepository
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
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder->select('p.role')
            ->where($queryBuilder->expr()->eq('p.project', ':project'))
            ->andWhere($queryBuilder->expr()->eq('p.user', ':user'))
            ->setParameters(array(':project' => $project, ':user' => $user))
            ->getQuery()->getArrayResult();
    }

    /**
     * Finds all of project given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ParticipantInterface[]
     */
    public function findByProject(ProjectInterface $project)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder->select(array('p', 'u', 'pr'))
            ->leftJoin('p.project', 'pr')
            ->leftJoin('p.user', 'u')
            ->where($queryBuilder->expr()->eq('p.project', ':project'))
            ->setParameter(':project', $project)
            ->getQuery()->getResult();

        return $this->findBy(array('project' => $project));
    }
}
