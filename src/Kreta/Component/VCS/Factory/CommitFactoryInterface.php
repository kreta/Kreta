<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Factory;

/**
 * Interface CommitFactoryInterface
 *
 * @package Kreta\Component\VCS\Factory
 */
interface CommitFactoryInterface
{
    /**
     * Creates a Commit object with the given response by the VCS provider
     *
     * @param array $args Decoded json array retrieved from the provider
     *
     * @return \Kreta\Component\VCS\Model\CommitInterface
     */
    public function create($args);
} 
