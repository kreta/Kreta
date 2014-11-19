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
     * Finds all the projects of participant given and ordered by value given.
     *
     * Can do pagination if $page is changed, starting from 0
     * and it can limit the search if $count is changed.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $participant The participant
     * @param string                                               $order       The order value
     * @param string|int                                           $count       The number of results
     * @param int                                                  $page        The number of page
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(UserInterface $participant, $order = 'name', $count = 10, $page = 0)
    {
        $order = 'p.' . $order;

        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('pu.user', ':participant'))
            ->leftJoin('p.participants', 'pu')
            ->setParameter(':participant', $participant->getId())
            ->orderBy($order);

        if ($count !== 0) {
            $queryBuilder
                ->setMaxResults($count)
                ->setFirstResult($count * $page);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds the project of id given.
     *
     * @param string $id The id
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    public function findOneById($id)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('p.id', ':id'))
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
