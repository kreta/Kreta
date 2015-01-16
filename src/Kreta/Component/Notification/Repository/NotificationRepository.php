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

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;

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
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user Target user
     *
     * @return int
     */
    public function getUsersUnreadNotificationsCount(UserInterface $user)
    {
        $queryBuilder = $this->getQueryBuilder()->select('count(n.id)');
        $this->addCriteria($queryBuilder, ['user' => $user, 'read' => false]);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Finds all unread notifications of user given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user Target user
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function findAllUnreadByUser(UserInterface $user)
    {
        return $this->findBy(['user' => $user, 'read' => false]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['p', 'u'])
            ->join('n.project', 'p')
            ->join('n.user', 'u');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'n';
    }
}
