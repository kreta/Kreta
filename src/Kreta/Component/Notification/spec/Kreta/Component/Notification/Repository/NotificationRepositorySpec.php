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

namespace spec\Kreta\Component\Notification\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class NotificationRepositorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class NotificationRepositorySpec extends ObjectBehavior
{
    use BaseEntityRepository;

    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Repository\NotificationRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_gets_users_unread_notification_count(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        UserInterface $user,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    ) {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $queryBuilder->select('count(n.id)')->shouldBeCalled()->willReturn($queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['user' => $user], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['read' => false], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleScalarResult()->shouldBeCalled()->willReturn(2);

        $this->getUsersUnreadNotificationsCount($user)->shouldReturn(2);
    }

    function it_finds_all_unread_notifications_by_user(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        UserInterface $user,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        NotificationInterface $notification
    ) {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['user' => $user], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['read' => false], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$notification]);

        $this->findAllUnreadByUser($user)->shouldReturn([$notification]);
    }

    function it_finds_by_user(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Func $func,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        NotificationInterface $notification,
        UserInterface $user
    ) {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['user' => $user], $comparison);
        $this->addLikeCriteriaSpec($queryBuilder, $expr, ['title' => 'notification-title'], $comparison);
        $this->addBetweenCriteriaSpec(
            $queryBuilder, $expr, $func, ['date' => [new \DateTime('2014-10-20'), Argument::type('DateTime')]]
        );
        $queryBuilder->setMaxResults(4)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(2)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$notification]);

        $this->findByUser(
            $user, ['date' => new \DateTime('2014-10-20'), 'title' => 'notification-title'], [], 4, 2
        )->shouldReturn([$notification]);
    }

    function it_finds_one_by_user(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        NotificationInterface $notification,
        UserInterface $user
    ) {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['id' => 'notification-id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($notification);

        $notification->getUser()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');

        $this->findOneByUser('notification-id', $user)->shouldReturn($notification);
    }

    function it_throws_access_denied_exception_because_the_user_is_not_the_owner_of_notification(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        NotificationInterface $notification,
        UserInterface $user,
        UserInterface $user2
    ) {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['id' => 'notification-id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($notification);

        $notification->getUser()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $user2->getId()->shouldBeCalled()->willReturn('user2-id');

        $this->shouldThrow(new AccessDeniedException())->during('findOneByUser', ['notification-id', $user2]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('n')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['p', 'u'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'n', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('n.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('n.user', 'u')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'n';
    }
}
