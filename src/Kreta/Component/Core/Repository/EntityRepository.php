<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EntityRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class EntityRepository extends BaseEntityRepository
{
    /**
     * Persists object.
     *
     * @param Object  $object The object that will be persisted
     * @param boolean $flush  Boolean that checks if flushes or not, by default is true
     *
     * @return void
     */
    public function persist($object, $flush = true)
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
    public function remove($object, $flush = true)
    {
        $this->_em->remove($object);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Finds a resource by its primary key / identifier.
     *
     * @param string  $id       The id
     * @param boolean $nullable Boolean that checks if the result can be null or not, by default is true
     *
     * @return Object|null
     * @throws \Doctrine\ORM\NoResultException If nullable is false and if the query returned no result.
     */
    public function find($id, $nullable = true)
    {
        return $nullable ? parent::find($id) : $this->findOneBy(['id' => $id], false);
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
     * @param boolean  $nullable Boolean that checks if the result can be null or not, by default is true
     * @param boolean  $strict   The strict mode, by default is true
     *
     * @return Object|null
     * @throws \Doctrine\ORM\NoResultException If nullable is false and if the query returned no result.
     */
    public function findOneBy(array $criteria, $nullable = true, $strict = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria, $strict);
        $query = $queryBuilder->getQuery();

        return $nullable ? $query->getOneOrNullResult() : $query->getSingleResult();
    }

    /**
     * Finds all the resources by criteria given.
     * Can do ordering, limit and offset.
     *
     * @param string[] $criteria Array which contains the criteria as key value
     * @param string[] $sorting  Array which contains the sorting as key value
     * @param int      $limit    The limit
     * @param int      $offset   The offset
     * @param boolean  $strict   The strict mode, by default is true
     *
     * @return array
     */
    public function findBy(array $criteria, array $sorting = [], $limit = null, $offset = null, $strict = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria, $strict);
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
     * @param boolean                    $strict       Boolean that checks if it is strict or not, useful to determine
     *                                                 if the query is eq or like
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function addCriteria(QueryBuilder $queryBuilder, array $criteria = [], $strict = true)
    {
        foreach ($criteria as $property => $value) {
            $rand = mt_rand();
            if ($strict && (null === $value)) {
                $queryBuilder->andWhere($queryBuilder->expr()->isNull($this->getPropertyName($property)));
            } elseif (is_array($value)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in($this->getPropertyName($property), $value));
            } elseif (!$strict && (null !== $value) && ('' !== $value)) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->like($this->getPropertyName($property), ':likeValue' . $rand))
                    ->setParameter('likeValue' . $rand, '%' . $value . '%');
            } elseif ($strict && ('' !== $value)) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq($this->getPropertyName($property), ':eqValue' . $rand))
                    ->setParameter('eqValue' . $rand, $value);
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
            if (!(array_keys($sorting) !== range(0, count($sorting) - 1))) {
                $property = $order;
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
