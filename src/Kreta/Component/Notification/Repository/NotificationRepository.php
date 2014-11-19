<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Repository;

use Doctrine\ORM\EntityRepository;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class NotificationRepository.
 *
 * @package Kreta\Component\Notification\Repository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * Gets the amount of notifications that user does not read yet.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user Target user
     *
     * @return integer Amount of unread notifications
     */
    public function getUsersUnreadNotificationsCount(UserInterface $user)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return $queryBuilder->select('count(n.id)')
            ->from($this->_entityName, 'n')
            ->where($queryBuilder->expr()->eq('n.user', ':userId'))
            ->andWhere($queryBuilder->expr()->eq('n.read', ':read'))
            ->setParameter(':userId', $user->getId())
            ->setParameter(':read', false)
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * Finds all unread notifications of user given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user Target user
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function findAllUnreadByUser(UserInterface $user)
    {
        $queryBuilder = $this->createQueryBuilder('n');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('n.user', ':userId'))
            ->andWhere($queryBuilder->expr()->eq('n.read', ':read'))
            ->orderBy('n.date', 'desc')
            ->setParameter(':userId', $user->getId())
            ->setParameter(':read', false)
            ->getQuery()->getResult();
    }
}
