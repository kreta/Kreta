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
use Kreta\Component\Core\Model\Interfaces\StatusInterface;

/**
 * Class StatusRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class StatusRepository extends EntityRepository
{
    /**
     * Persists status.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface $status The status
     */
    public function save(StatusInterface $status)
    {
        $this->_em->persist($status);
        $this->_em->flush();
    }

    /**
     * Removes status.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface $status The status
     */
    public function delete(StatusInterface $status)
    {
        $this->_em->remove($status);
        $this->_em->flush();
    }

    /**
     * Finds all the status that exist into database.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('s')->getQuery()->getResult();
    }

    /**
     * Finds all the status of project given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    public function findByProject(ProjectInterface $project)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.project', ':project'))
            ->setParameter(':project', $project->getId())
            ->getQuery()->getResult();
    }

    /**
     * Finds the status of name and project id given.
     *
     * @param string $name      The name
     * @param string $projectId The project id
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface
     */
    public function findOneByNameAndProjectId($name, $projectId)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.name', ':name'))
            ->andWhere($queryBuilder->expr()->eq('s.project', ':project'))
            ->setParameter(':name', $name)
            ->setParameter(':project', $projectId)
            ->getQuery()->getOneOrNullResult();
    }
}
