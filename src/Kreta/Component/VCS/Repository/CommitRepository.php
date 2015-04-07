<?php

/*
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
 * Class CommitRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class CommitRepository extends EntityRepository
{
    /**
     * Finds all the commits of issue id given.
     *
     * @param string $issueId The issue id
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\CommitInterface[]
     */
    public function findByIssue($issueId)
    {
        return $this->findBy(['ir.id' => $issueId]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['b', 'ir'])
            ->innerJoin('c.branch', 'b')
            ->innerJoin('c.issuesRelated', 'ir');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'c';
    }
}
