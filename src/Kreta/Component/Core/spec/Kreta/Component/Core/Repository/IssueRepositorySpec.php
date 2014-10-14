<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueRepositorySpec.
 *
 * @package spec\Kreta\Component\Core\Repository
 */
class IssueRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\IssueRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

//    function it_finds_by_reporter(
//        UserInterface $reporter,
//        EntityRepository $repository,
//        QueryBuilder $queryBuilder,
//        Expr $expr,
//        Expr\Comparison $comparison,
//        AbstractQuery $query
//    )
//    {
//        $repository->createQueryBuilder('i')->shouldBeCalled()->willReturn($queryBuilder);
//
//        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
//        $expr->eq('i.reporter', ':reporter')->shouldBeCalled()->willReturn($comparison);
//        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
//        $reporter->getId()->shouldBeCalled()->willReturn('reporter-id');
//        $queryBuilder->setParameter(':reporter', 'reporter-id')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
//        $query->getResult()->shouldBeCalled()->willReturn(array());
//
//        $this->findByReporter($reporter);
//    }
//
//    function it_finds_by_assignee(
//        UserInterface $assignee,
//        EntityRepository $repository,
//        QueryBuilder $queryBuilder,
//        Expr $expr,
//        Expr\Comparison $comparison,
//        AbstractQuery $query
//    )
//    {
//        $repository->createQueryBuilder('i')->shouldBeCalled()->willReturn($queryBuilder);
//
//        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
//        $expr->eq('i.assignee', ':assignee')->shouldBeCalled()->willReturn($comparison);
//        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
//        $assignee->getId()->shouldBeCalled()->willReturn('assignee-id');
//        $queryBuilder->setParameter(':assignee', 'assignee-id')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
//        $query->getResult()->shouldBeCalled()->willReturn(array());
//
//        $this->findByAssignee($assignee);
//    }
}
