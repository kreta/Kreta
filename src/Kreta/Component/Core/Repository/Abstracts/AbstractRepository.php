<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Repository\Abstracts;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract class AbstractRepository.
 *
 * @package Kreta\Component\Core\Repository\Abstracts
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * Gets the entity name alias.
     *
     * @abstract
     */
    abstract protected function getAlias();

    /**
     * Persists object.
     *
     * @param Object  $object The object that will be persisted
     * @param boolean $flush  Boolean that checks if flushes or not, by default is true
     *
     * @return void
     */
    public function save($object, $flush = true)
    {
        $this->_em->persist($object);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Removes object.
     *
     * @param Object  $object The object that will be removed
     * @param boolean $flush  Boolean that checks if flushes or not, by default is true
     *
     * @return void
     */
    public function delete($object, $flush = true)
    {
        $this->_em->remove($object);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Finds all the resources.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->getQueryBuilder()->getQuery()->getResult();
    }

    /**
     * Finds the resource by criteria given.
     *
     * @param string[] $criteria Array which contains the criteria as key value
     *
     * @return Object|null
     */
    public function findOneBy(array $criteria)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Finds all the resources by criteria given.
     * Can do ordering, limit and offset.
     *
     * @param string[] $criteria Array which contains the criteria as key value
     * @param string[] $sorting  Array which contains the sorting as key value
     * @param int      $limit    The limit
     * @param int      $offset   The offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $sorting = [], $limit = null, $offset = null)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria);
        $this->orderBy($queryBuilder, $sorting);
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Gets query builder.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    /**
     * Manages the criteria by statement into queries.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string[]                   $criteria     Array which contains the criteria as key value
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addCriteria(QueryBuilder $queryBuilder, array $criteria = [])
    {
        foreach ($criteria as $property => $value) {
            if (null === $value) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->isNull($this->getPropertyName($property)));
            } elseif (is_array($value)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in($this->getPropertyName($property), $value));
            } elseif ('' !== $value) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq($this->getPropertyName($property), ':' . $property))
                    ->setParameter($property, $value);
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
    protected function orderBy(QueryBuilder $queryBuilder, array $sorting = [])
    {
        foreach ($sorting as $property => $order) {
            if (empty($order)) {
                $order = 'DESC';
            }
            $queryBuilder->addOrderBy($this->getPropertyName($property), $order);
        }

        return $queryBuilder;
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
        if (!strpos($name, '.')) {
            return $this->getAlias() . '.' . $name;
        }

        return $name;
    }
}
