<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Repository;

use Doctrine\ORM\EntityRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class StatusRepository.
 *
 * @package Kreta\Component\Workflow\Repository
 */
class StatusRepository extends EntityRepository
{
    /**
     * Persists status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     */
    public function save(StatusInterface $status)
    {
        $this->_em->persist($status);
        $this->_em->flush();
    }

    /**
     * Removes status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     */
    public function delete(StatusInterface $status)
    {
        $this->_em->remove($status);
        $this->_em->flush();
    }

    /**
     * Finds all the status that exist into database.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('s')->getQuery()->getResult();
    }

    /**
     * Finds the status of name given otherwise returns null.
     *
     * @param string $name The name
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface|null
     */
    public function findOneByName($name)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.name', ':name'))
            ->setParameter(':name', $name)
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * Finds the status of name and project id given otherwise returns null.
     *
     * @param string $name      The name
     * @param string $projectId The project id
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface|null
     */
    public function findOneByNameAndProjectId($name, $projectId)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.name', ':name'))
            ->andWhere($queryBuilder->expr()->eq('s.project', ':project'))
            ->setParameter(':name', $name)
            ->setParameter(':project', $projectId)
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * Finds the status of workflow given.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function findByWorkflow(WorkflowInterface $workflow)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.workflow', ':workflow'))
            ->setParameter('workflow', $workflow)
            ->getQuery()->getResult();
    }

    /**
     * Finds the status of ids given.
     *
     * @param mixed                                                        $ids      A collection of ids, can be an
     *                                                                               simple string with comma separated
     *                                                                               or an array
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function findByIds($ids, WorkflowInterface $workflow)
    {
        if (!(is_array($ids))) {
            $ids = explode(',', str_replace(' ', '', $ids));
        }

        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('s.id', ':id'))
            ->andWhere($queryBuilder->expr()->eq('s.workflow', ':workflow'))
            ->setParameter('workflow', $workflow);

        $result = [];
        foreach ($ids as $id) {
            $status = $queryBuilder
                ->setParameter('id', $id)
                ->getQuery()->getOneOrNullResult();

            if ($status instanceof StatusInterface) {
                $result[] = $status;
            }
        }

        return array_unique($result);
    }
}
