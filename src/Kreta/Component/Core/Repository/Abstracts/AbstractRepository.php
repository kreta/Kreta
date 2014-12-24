<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Repository\Abstracts;

use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractRepository.
 *
 * @package Kreta\Component\Core\Repository\Abstracts
 */
class AbstractRepository extends EntityRepository
{
    /**
     * Persists object.
     *
     * @param Object $object The object that will be persisted
     */
    public function save($object)
    {
        $this->_em->persist($object);
        $this->_em->flush();
    }

    /**
     * Removes object.
     *
     * @param Object $object The object that will be removed
     */
    public function delete($object)
    {
        $this->_em->remove($object);
        $this->_em->flush();
    }
}
