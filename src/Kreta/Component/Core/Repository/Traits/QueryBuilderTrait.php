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

namespace Kreta\Component\Core\Repository\Traits;

use Doctrine\ORM\QueryBuilder;

/**
 * Trait QueryBuilderTrait.
 *
 * @package Kreta\Component\Core\Repository\Traits
 */
trait QueryBuilderTrait
{
    /**
     * Manages the criteria by statement into queries.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string[]                   $criteria     Array which contains the criteria as key value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function addCriteria(QueryBuilder $queryBuilder, array $criteria = [])
    {
        foreach ($criteria as $key => $properties) {
            if (!(is_array($properties))) {
                $properties = [$key => $properties];
                $key = 'eq';
            }
            foreach ($properties as $property => $value) {
                if (method_exists($this, $method = 'add' . ucfirst($key) . 'Criteria')) {
                    $this->$method($queryBuilder, $property, $value);
                }
            }
        }

        return $queryBuilder;
    }

    /**
     * Manages the order by statement into queries.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string[]                   $sorting      Array which contains the sorting as key value,
     *                                                 if order is empty, the default value is DESC
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function orderBy(QueryBuilder $queryBuilder, array $sorting = [])
    {
        foreach ($sorting as $property => $order) {
            if (!(array_keys($sorting) !== range(0, count($sorting) - 1))) {
                $property = $order;
                $order = 'DESC';
            }
            $queryBuilder->addOrderBy($this->getPropertyName($property), $order);
        }

        return $queryBuilder;
    }

    /**
     * Composes the EQUAL query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param string                     $value        The value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addEqCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        $rand = mt_rand();

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->eq($this->getPropertyName($property), ':eqValue' . $rand))
            ->setParameter('eqValue' . $rand, $value);
    }

    /**
     * Composes the NOT EQUAL query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param string                     $value        The value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addNeqCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        $rand = mt_rand();

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->neq($this->getPropertyName($property), ':neqValue' . $rand))
            ->setParameter('neqValue' . $rand, $value);
    }

    /**
     * Composes the LIKE query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param string                     $value        The value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addLikeCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        $rand = mt_rand();

        if (null !== $value && '' !== $value) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like($this->getPropertyName($property), ':likeValue' . $rand))
                ->setParameter('likeValue' . $rand, '%' . $value . '%');
        }

        return $queryBuilder;
    }

    /**
     * Composes the IS NULL query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param string                     $value        The value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addIsNullCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        if (null === $value) {
            $queryBuilder->andWhere($queryBuilder->expr()->isNull($this->getPropertyName($property)));
        }

        return $queryBuilder;
    }

    /**
     * Composes the IN query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param string                     $value        The value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addInCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        if (is_array($value)) {
            $queryBuilder->andWhere($queryBuilder->expr()->in($this->getPropertyName($property), $value));
        }

        return $queryBuilder;
    }

    /**
     * Composes the BETWEEN query builder expression.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string                     $property     The property
     * @param \DateTime|array            $value        The value can be datetime or array which contains two datetimes
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addBetweenCriteria(QueryBuilder $queryBuilder, $property, $value)
    {
        if ($value instanceof \DateTime) {
            $now = new \DateTime();

            return $queryBuilder
                ->andWhere($queryBuilder->expr()->between($this->getPropertyName($property), ':from', ':to'))
                ->setParameter('from', $value->format('Y-m-d'))
                ->setParameter('to', $now->format('Y-m-d'));
        }

        if (is_array($value)
            && count($value) === 2
            && $value[0] instanceof \DateTime
            && $value[1] instanceof \DateTime
        ) {
            return $queryBuilder
                ->andWhere($queryBuilder->expr()->between($this->getPropertyName($property), ':from', ':to'))
                ->setParameter('from', $value[0]->format('Y-m-d'))
                ->setParameter('to', $value[1]->format('Y-m-d'));
        }
    }

    /**
     * Gets property name.
     *
     * @param string $name The property name
     *
     * @return string
     */
    protected function getPropertyName($name)
    {
        return !strpos($name, '.') ? $this->getAlias() . '.' . $name : $name;
    }

    /**
     * Gets the entity name alias.
     *
     * @return string
     */
    protected function getAlias()
    {
        return 'kreta';
    }
}
