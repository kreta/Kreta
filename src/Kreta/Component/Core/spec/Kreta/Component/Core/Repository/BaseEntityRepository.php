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

namespace Kreta\Component\Core\spec\Kreta\Component\Core\Repository;

use Doctrine\ORM\Query\Expr;
use PhpSpec\Wrapper\Collaborator;
use Prophecy\Argument;

/**
 * Class BaseEntityRepository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
trait BaseEntityRepository
{
    protected function getQueryBuilderSpec(Collaborator $manager, Collaborator $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('kreta')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'kreta', null)->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addCriteriaSpec(
        Collaborator $queryBuilder,
        Collaborator $expr,
        array $values,
        Collaborator $comparison
    )
    {
        return $this->addEqCriteriaSpec($queryBuilder, $expr, $values, $comparison);
    }

    protected function addEqCriteriaSpec(
        Collaborator $queryBuilder,
        Collaborator $expr,
        array $values,
        Collaborator $comparison
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
        Collaborator $queryBuilder,
        Collaborator $expr,
        array $values,
        Collaborator $comparison
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
        Collaborator $queryBuilder,
        Collaborator $expr,
        array $values,
        Collaborator $comparison
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

    protected function addIsNullCriteriaSpec(Collaborator $queryBuilder, Collaborator $expr, $property)
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->isNull($this->getPropertyNameSpec($property))->shouldBeCalled()->willReturn('kreta.property IS NULL');
        $queryBuilder->andWhere('kreta.property IS NULL')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addInCriteriaSpec(Collaborator $queryBuilder, Collaborator $expr, Collaborator $func, array $values)
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->in($this->getPropertyNameSpec(key($values)), $values[key($values)])->shouldBeCalled()->willReturn($func);
        $queryBuilder->andWhere($func)->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addBetweenCriteriaSpec(Collaborator $queryBuilder, Collaborator $expr, Collaborator $func, array $values)
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

    protected function orderBySpec(Collaborator $queryBuilder, array $sorting)
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

