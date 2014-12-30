<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model\Interfaces;

/**
 * Interface BranchInterface
 *
 * @package Kreta\Component\VCS\Model
 */
interface BranchInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Sets id.
     *
     * @param string $id
     *
     * @return self
     */
    public function setId($id);

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Gets repository.
     *
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * Sets repository.
     *
     * @param RepositoryInterface $repository
     *
     * @return self
     */
    public function setRepository(RepositoryInterface $repository);
}
