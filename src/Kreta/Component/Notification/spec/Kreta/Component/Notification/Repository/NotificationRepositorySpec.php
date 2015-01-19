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
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Prophecy\Argument;

/**
 * Class NotificationRepositorySpec.
 *
 * @package spec\Kreta\Component\Notification\Repository
 */
class NotificationRepositorySpec extends BaseEntityRepository
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
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
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
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['user' => $user], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['read' => false], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$notification]);

        $this->findAllUnreadByUser($user)->shouldReturn([$notification]);
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
