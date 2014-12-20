<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Repository;

use Doctrine\ORM\EntityRepository;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class ParticipantRepository.
 *
 * @package Kreta\Component\Project\Repository
 */
class ParticipantRepository extends EntityRepository
{
    /**
     * Finds all of project given.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[]
     */
    public function findByProject(ProjectInterface $project)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return $queryBuilder->select(['p', 'u', 'pr'])
            ->from($this->_entityName, 'p')
            ->leftJoin('p.project', 'pr')
            ->leftJoin('p.user', 'u')
            ->where($queryBuilder->expr()->eq('p.project', ':project'))
            ->setParameter(':project', $project)
            ->getQuery()->getResult();
    }
}
