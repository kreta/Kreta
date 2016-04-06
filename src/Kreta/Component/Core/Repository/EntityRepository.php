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

namespace Kreta\Component\Core\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Kreta\Component\Core\Repository\Traits\QueryBuilderTrait;

/**
 * Class EntityRepository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class EntityRepository extends BaseEntityRepository
{
    use QueryBuilderTrait;

    /**
     * Persists object.
     *
     * @param object $object The object that will be persisted
     * @param bool   $flush  Boolean that checks if flushes or not, by default is true
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
     * @param object $object The object that will be removed
     * @param bool   $flush  Boolean that checks if flushes or not, by default is true
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
     * @param string $id       The id
     * @param bool   $nullable Boolean that checks if the result can be null or not, by default is true
     *
     * @throws \Doctrine\ORM\NoResultException If nullable is false and if the query returned no result.
     *
     * @return object|null
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
     * @param bool     $nullable Boolean that checks if the result can be null or not, by default is true
     *
     * @throws \Doctrine\ORM\NoResultException If nullable is false and if the query returned no result.
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, $nullable = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $criteria);
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
}
