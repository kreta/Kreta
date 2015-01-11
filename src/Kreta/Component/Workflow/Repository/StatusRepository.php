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

use Kreta\Component\Core\Repository\EntityRepository;
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

        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, ['workflow' => $workflow]);
        $queryBuilder->andWhere($queryBuilder->expr()->eq('s.id', ':id'));

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

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['w'])
            ->join('s.workflow', 'w');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 's';
    }
}
