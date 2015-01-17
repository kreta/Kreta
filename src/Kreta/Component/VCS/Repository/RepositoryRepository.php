<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Repository;

use Kreta\Component\Core\Repository\EntityRepository;

/**
 * Class RepositoryRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class RepositoryRepository extends EntityRepository
{
    /**
     * Finds all the repositories of issue id given.
     *
     * @param string $issueId The issue id
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface[]
     */
    public function findByIssue($issueId)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('p.issues', 'i');
        $this->addCriteria($queryBuilder, ['i.id' => $issueId]);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['p'])
            ->leftJoin('r.projects', 'p');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'r';
    }
}

