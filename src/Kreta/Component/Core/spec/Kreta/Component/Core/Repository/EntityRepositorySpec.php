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

namespace spec\Kreta\Component\Core\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Prophecy\Argument;

/**
 * Class EntityRepositorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class EntityRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_extends_doctrines_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

    function it_persists_without_flush(EntityManager $manager)
    {
        $manager->persist(Argument::type('Object'))->shouldBeCalled();

        $this->persist(Argument::type('Object'), false);
    }

    function it_persists_with_flush(EntityManager $manager)
    {
        $manager->persist(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->persist(Argument::type('Object'), true);
    }

    function it_removes_without_flush(EntityManager $manager)
    {
        $manager->remove(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->remove(Argument::type('Object'), true);
    }

    function it_removes_with_flush(EntityManager $manager)
    {
        $manager->remove(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->remove(Argument::type('Object'), true);
    }

    function it_finds_nullable(EntityManager $manager)
    {
        $object = Argument::type('Object');

        $manager->find(null, 'id', Argument::any(), null)->shouldBeCalled()->willReturn($object);

        $this->find('id')->shouldReturn($object);
    }

    function it_finds_nullable_without_result(EntityManager $manager)
    {
        $manager->find(null, 'id', Argument::any(), null)->shouldBeCalled()->willReturn(null);

        $this->find('id')->shouldReturn(null);
    }

    function it_finds(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $object = Argument::type('Object');

        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['id' => 'id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($object);

        $this->find('id', false)->shouldReturn($object);
    }

    function it_finds_without_result(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['id' => 'id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn(null);

        $this->find('id', false)->shouldReturn(null);
    }

    function it_finds_all(EntityManager $manager, QueryBuilder $queryBuilder, AbstractQuery $query)
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findAll()->shouldBeArray();
    }

    function it_finds_one_by_nullable(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $object = Argument::type('Object');

        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'dummy name'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getOneOrNullResult()->shouldBeCalled()->willReturn($object);

        $this->findOneBy(['name' => 'dummy name'], true, false)->shouldReturn($object);
    }

    function it_finds_one_nullable_without_result(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'dummy name'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);

        $query->getOneOrNullResult()->shouldBeCalled()->willReturn(null);

        $this->findOneBy(['name' => 'dummy name'], true, false)->shouldReturn(null);
    }

    function it_finds_one_by(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $object = Argument::type('Object');

        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'dummy name'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($object);

        $this->findOneBy(['name' => 'dummy name'], false, false)->shouldReturn($object);
    }

    function it_finds_one_by_without_result(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'dummy name'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);

        $query->getSingleResult()->shouldBeCalled()->willReturn(null);

        $this->findOneBy(['name' => 'dummy name'], false, false)->shouldReturn(null);
    }

    function it_finds_by(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $object = Argument::type('Object');

        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'dummy name'], $comparison);
        $this->orderBySpec($queryBuilder, ['name' => 'DESC']);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(3)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$object]);

        $this->findBy(['name' => 'dummy name'], ['name'], 10, 3)->shouldReturn([$object]);
    }
}
