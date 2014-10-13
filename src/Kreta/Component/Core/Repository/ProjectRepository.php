<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;

/**
 * Class ProjectRepository.
 *
 * @package Kreta\CoreBundle\Rpository
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Finds all the issues of participant given.
     *
     * @param \Kreta\CoreBundle\Model\Interfaces\UserInterface $participant The reporter
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(UserInterface $participant)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder->select('p')
            ->where($queryBuilder->expr()->eq('p.participants', ':participant'))
            ->setParameter(':participant', $participant->getId())
            ->getQuery()->getResult();
    }
}
