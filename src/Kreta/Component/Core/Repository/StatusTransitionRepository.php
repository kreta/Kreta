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

use Doctrine\ORM\EntityRepository;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;

/**
 * Class StatusTransitionRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class StatusTransitionRepository extends EntityRepository
{
    /**
     * Finds all the status transitions of project given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface[]
     */
    public function findByProject(ProjectInterface $project)
    {
        $queryBuilder = $this->createQueryBuilder('st');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('st.project', ':project'))
            ->setParameter(':project', $project->getId())
            ->getQuery()->getResult();
    }
}
