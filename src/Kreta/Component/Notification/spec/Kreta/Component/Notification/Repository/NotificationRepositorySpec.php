<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NotificationRepositorySpec.
 *
 * @package spec\Kreta\Component\Notification\Repository
 */
class NotificationRepositorySpec extends ObjectBehavior
{
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
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

    function it_gets_users_unread_notification_count(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        UserInterface $user,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->select('count(n.id)')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'n')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('n.user', ':userId')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('n.read', ':read')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':userId', '231231')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':read', false)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleScalarResult()->shouldBeCalled()->willReturn(2);

        $user->getId()->shouldBeCalled()->willReturn('231231');

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
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('n')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'n')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('n.user', ':userId')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('n.read', ':read')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->orderBy('n.date', 'desc')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':userId', '222')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':read', false)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$notification]);
        $user->getId()->shouldBeCalled()->willReturn('222');

        $this->findAllUnreadByUser($user)->shouldReturn([$notification]);
    }
}
