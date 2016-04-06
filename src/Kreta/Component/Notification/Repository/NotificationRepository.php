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

namespace Kreta\Component\Notification\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class NotificationRepository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
     * Finds all the notifications of user given with many filters.
     * Can do ordering, limit and offset.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user    The user
     * @param array                                                $filters Array which contains the available filters
     * @param string[]                                             $sorting Array which contains the sorting as key/val
     * @param int                                                  $limit   The limit
     * @param int                                                  $offset  The offset
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function findByUser(
        UserInterface $user,
        array $filters = [],
        array $sorting = [],
        $limit = null,
        $offset = null
    ) {
        $between = [];
        if (array_key_exists('date', $filters) && $filters['date'] instanceof \DateTime) {
            $between = [$filters['date'], new \DateTime()];
            unset($filters['date']);
        }
        $queryBuilder = $this->getQueryBuilder();

        $this->addCriteria($queryBuilder, ['user' => $user, 'like' => $filters, 'between' => ['date' => $between]]);
        $this->orderBy($queryBuilder, $sorting);
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds the notifications of id and user given.
     *
     * @param string                                               $notificationId The notification id
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user           The user
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface
     */
    public function findOneByUser($notificationId, UserInterface $user)
    {
        $notification = $this->find($notificationId, false);
        if ($notification->getUser()->getId() !== $user->getId()) {
            throw new AccessDeniedException();
        }

        return $notification;
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
