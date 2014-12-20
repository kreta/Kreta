<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\User\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository.
 *
 * @package Kreta\Component\User\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * Finds all the users that exist into database.
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface[]
     */
    public function findAll()
    {
        return $this->createQueryBuilder('u')->getQuery()->getResult();
    }
}
