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
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class ProjectRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Finds all the project that exist into database.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('p')->getQuery()->getResult();
    }

    /**
     * Finds all the issues of participant given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $participant The reporter
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(UserInterface $participant)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder->select('p')
            ->where($queryBuilder->expr()->eq('p.participants', ':participant'))
            ->setParameter(':participant', $participant->getId())
            ->getQuery()->getResult();
    }
}
