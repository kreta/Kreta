<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\spec\Kreta\Component\Core\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BaseEntityRepository.
 *
 * @package Kreta\Component\Core\spec\Kreta\Component\Core\Repository
 */
class BaseEntityRepository extends ObjectBehavior
{
    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('kreta')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'kreta', null)->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addCriteriaSpec(
        QueryBuilder $queryBuilder,
        Expr $expr,
        array $values,
        Expr\Comparison $comparison
    )
    {
        return $this->addEqCriteriaSpec($queryBuilder, $expr, $values, $comparison);
    }

    protected function addEqCriteriaSpec(
        QueryBuilder $queryBuilder,
        Expr $expr,
        array $values,
        Expr\Comparison $comparison
    )
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq($this->getPropertyNameSpec(key($values)), Argument::containingString(':eqValue'))
            ->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::containingString('eqValue'), $values[key($values)])
            ->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addNeqCriteriaSpec(
        QueryBuilder $queryBuilder,
        Expr $expr,
        array $values,
        Expr\Comparison $comparison
    )
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->neq($this->getPropertyNameSpec(key($values)), Argument::containingString(':neqValue'))
            ->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::containingString('neqValue'), $values[key($values)])
            ->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addLikeCriteriaSpec(
        QueryBuilder $queryBuilder,
        Expr $expr,
        array $values,
        Expr\Comparison $comparison
    )
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->like($this->getPropertyNameSpec(key($values)), Argument::containingString(':likeValue'))
            ->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::containingString('likeValue'), '%' . $values[key($values)] . '%')
            ->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addIsNullCriteriaSpec(QueryBuilder $queryBuilder, Expr $expr, $property)
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->isNull($this->getPropertyNameSpec($property))->shouldBeCalled()->willReturn('kreta.property IS NULL');
        $queryBuilder->andWhere('kreta.property IS NULL')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addInCriteriaSpec(QueryBuilder $queryBuilder, Expr $expr, Expr\Func $func, array $values)
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->in($this->getPropertyNameSpec(key($values)), $values[key($values)])->shouldBeCalled()->willReturn($func);
        $queryBuilder->andWhere($func)->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addBetweenCriteriaSpec(QueryBuilder $queryBuilder, Expr $expr, Expr\Func $func, array $values)
    {
        $now = new \DateTime();
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->between($this->getPropertyNameSpec(key($values)), ':from', ':to')
            ->shouldBeCalled()->willReturn($func);
        $queryBuilder->andWhere($func)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('from', Argument::type('string'))->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('to', $now->format('Y-m-d'))->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function orderBySpec(QueryBuilder $queryBuilder, array $sorting)
    {
        $queryBuilder->addOrderBy($this->getPropertyNameSpec(key($sorting)), $sorting[key($sorting)])
            ->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getPropertyNameSpec($name)
    {
        return !strpos($name, '.') ? $this->getAlias() . '.' . $name : $name;
    }

    protected function getAlias()
    {
        return 'kreta';
    }
}

