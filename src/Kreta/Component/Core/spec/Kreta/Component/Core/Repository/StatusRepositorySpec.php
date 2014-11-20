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
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusRepositorySpec.
 *
 * @package spec\Kreta\Component\Core\Repository
 */
class StatusRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\StatusRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

    function it_saves(EntityManager $manager, StatusInterface $status)
    {
        $manager->persist($status)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->save($status);
    }

    function it_removes(EntityManager $manager, StatusInterface $status)
    {
        $manager->remove($status)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->delete($status);
    }

    function it_finds_all(EntityManager $manager, QueryBuilder $queryBuilder, AbstractQuery $query)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('s')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 's')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findAll()->shouldBeArray();
    }

    function it_finds_by_project(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        ProjectInterface $project
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('s')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 's')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('s.project', ':project')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $project->getId()->shouldBeCalled()->willReturn('project-id');
        $queryBuilder->setParameter(':project', 'project-id')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findByProject($project)->shouldBeArray();
    }

    function it_finds_one_by_name_and_project_id(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        StatusInterface $status
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('s')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 's')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('s.name', ':name')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('s.project', ':project')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':name', 'status name')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':project', 'project-id')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getOneOrNullResult()->shouldBeCalled()->willReturn($status);

        $this->findOneByNameAndProjectId('status name', 'project-id')->shouldReturn($status);
    }
}
