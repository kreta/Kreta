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
     * @param Object  $object The object that will be persisted
     * @param boolean $flush  Boolean that checks if flushes or not, by default is true
     *
     * @return void
     */
    public function save($object, $flush = true)
    {
        $this->_em->persist($object);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Removes object.
     *
     * @param Object  $object The object that will be removed
     * @param boolean $flush  Boolean that checks if flushes or not, by default is true
     *
     * @return void
     */
    public function delete($object, $flush = true)
    {
        $this->_em->remove($object);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
