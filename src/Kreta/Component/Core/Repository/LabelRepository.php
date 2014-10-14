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

/**
 * Class LabelRepository.
 *
 * @package Kreta\CoreBundle\Rpository
 */
class LabelRepository extends EntityRepository
{
    /**
     * Finds all the user that exist into database.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\LabelInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('l')->getQuery()->getResult();
    }
}
