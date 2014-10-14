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

/**
 * Class ResolutionRepository.
 *
 * @package Kreta\CoreBundle\Rpository
 */
class ResolutionRepository extends EntityRepository
{
    /**
     * Finds all the resolutions that exist into database.
     *
     * @return \Kreta\CoreBundle\Model\Interfaces\ResolutionInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('r')->getQuery()->getResult();
    }
}
