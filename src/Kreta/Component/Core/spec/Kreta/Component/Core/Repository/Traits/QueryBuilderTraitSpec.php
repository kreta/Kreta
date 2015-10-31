<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Repository\Traits;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Prophecy\Argument;

/**
 * Class QueryBuilderTraitSpec.
 *
 * @package spec\Kreta\Component\Core\Repository\Traits
 */
class QueryBuilderTraitSpec extends BaseEntityRepository
{
    function let()
    {
        $this->beAnInstanceOf('Kreta\Component\Core\Stubs\Repository\QueryBuilderTraitStub');
    }

    function it_adds_eq_criteria(QueryBuilder $queryBuilder, Expr $expr, Expr\Comparison $comparison)
    {
        $value = Argument::type('Object');
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['property' => $value], $comparison);

        $this->addCriteria($queryBuilder, ['property' => $value])->shouldReturn($queryBuilder);
    }

    function it_adds_neq_criteria(QueryBuilder $queryBuilder, Expr $expr, Expr\Comparison $comparison)
    {
        $value = Argument::type('Object');
        $this->addNeqCriteriaSpec($queryBuilder, $expr, ['property' => $value], $comparison);

        $this->addCriteria($queryBuilder, ['neq' => ['property' => $value]])->shouldReturn($queryBuilder);
    }

    function it_adds_like_criteria(QueryBuilder $queryBuilder, Expr $expr, Expr\Comparison $comparison)
    {
        $value = Argument::type('Object');
        $this->addLikeCriteriaSpec($queryBuilder, $expr, ['property' => $value], $comparison);

        $this->addCriteria($queryBuilder, ['like' => ['property' => $value]])->shouldReturn($queryBuilder);
    }

    function it_adds_like_criteria_with_null_or_empty_value(QueryBuilder $queryBuilder)
    {
        $this->addCriteria($queryBuilder, ['like' => ['property' => '']])->shouldReturn($queryBuilder);
        $this->addCriteria($queryBuilder, ['like' => ['property' => null]])->shouldReturn($queryBuilder);
    }

    function it_adds_is_null_criteria(QueryBuilder $queryBuilder, Expr $expr)
    {
        $this->addIsNullCriteriaSpec($queryBuilder, $expr, 'property');

        $this->addCriteria($queryBuilder, ['isNull' => ['property' => null]])->shouldReturn($queryBuilder);
    }

    function it_adds_is_null_criteria_without_null_value(QueryBuilder $queryBuilder)
    {
        $this->addCriteria(
            $queryBuilder, ['isNull' => ['property' => Argument::type('Object')]]
        )->shouldReturn($queryBuilder);
    }

    function it_adds_in_criteria(QueryBuilder $queryBuilder, Expr $expr, Expr\Func $func)
    {
        $value = Argument::type('Object');
        $this->addInCriteriaSpec($queryBuilder, $expr, $func, ['property' => [$value]]);

        $this->addCriteria($queryBuilder, ['in' => ['property' => [$value]]])->shouldReturn($queryBuilder);
    }

    function it_adds_in_criteria_without_array_value(QueryBuilder $queryBuilder)
    {
        $this->addCriteria(
            $queryBuilder, ['in' => ['property' => Argument::type('Object')]]
        )->shouldReturn($queryBuilder);
    }

    function it_adds_between_criteria_with_datetimes_array_value(
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Func $func
    )
    {
        $from = new \DateTime();
        $to = new \DateTime();
        $this->addBetweenCriteriaSpec($queryBuilder, $expr, $func, ['property' => [$from, $to]]);

        $this->addCriteria(
            $queryBuilder, ['between' => ['property' => [$from, $to]]]
        )->shouldReturn($queryBuilder);
    }

    function it_adds_between_criteria_with_datetime_value(QueryBuilder $queryBuilder, Expr $expr, Expr\Func $func)
    {
        $datetime = new \DateTime();
        $this->addBetweenCriteriaSpec($queryBuilder, $expr, $func, ['property' => $datetime]);

        $this->addCriteria(
            $queryBuilder, ['between' => ['property' => $datetime]]
        )->shouldReturn($queryBuilder);
    }

    function it_adds_between_criteria_without_datetimes_array_value(QueryBuilder $queryBuilder)
    {
        $this->addCriteria(
            $queryBuilder, ['between' => ['property' => ['not-datetime', 'not-datetime']]]
        )->shouldReturn($queryBuilder);
    }

    function it_adds_between_criteria_without_datetime_value(QueryBuilder $queryBuilder)
    {
        $this->addCriteria($queryBuilder, ['between' => ['property' => 'not-datetime']])->shouldReturn($queryBuilder);
    }

    function it_orders_by(QueryBuilder $queryBuilder)
    {
        $this->orderBySpec($queryBuilder, ['property' => 'DESC']);

        $this->orderBy($queryBuilder, ['property'])->shouldReturn($queryBuilder);
    }

    function it_orders_by_with_asc(QueryBuilder $queryBuilder)
    {
        $this->orderBySpec($queryBuilder, ['property' => 'ASC']);

        $this->orderBy($queryBuilder, ['property' => 'ASC'])->shouldReturn($queryBuilder);
    }
}
