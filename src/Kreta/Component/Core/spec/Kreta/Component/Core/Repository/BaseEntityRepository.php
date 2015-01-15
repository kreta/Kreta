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
        $queryBuilder->from(Argument::any(), 'kreta')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function addCriteriaSpec(
        QueryBuilder $queryBuilder,
        Expr $expr,
        array $values,
        Expr\Comparison $comparison,
        $comparisonType = 'eq'
    )
    {
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        switch ($comparisonType) {
            case 'isNull':
                $expr->isNull($this->getPropertyNameSpec(key($values)))->shouldBeCalled()->willReturn($comparison);
                $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
                break;
            case 'in':
                $expr->in($this->getPropertyNameSpec(key($values)), $values[key($values)])
                    ->shouldBeCalled()->willReturn($comparison);
                $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
                break;
            case 'like':
                $expr->like($this->getPropertyNameSpec(key($values)), Argument::containingString(':likeValue'))
                    ->shouldBeCalled()->willReturn($comparison);
                $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
                $queryBuilder->setParameter(Argument::containingString('likeValue'), '%' . $values[key($values)] . '%')
                    ->shouldBeCalled()->willReturn($queryBuilder);
                break;
            default:
                $expr->eq($this->getPropertyNameSpec(key($values)), Argument::containingString(':eqValue'))
                    ->shouldBeCalled()->willReturn($comparison);
                $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
                $queryBuilder->setParameter(Argument::containingString('eqValue'), $values[key($values)])
                    ->shouldBeCalled()->willReturn($queryBuilder);
                break;
        }

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

