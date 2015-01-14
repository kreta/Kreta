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
 * Class BranchFactory.
 *
 * @package Kreta\Component\VCS\Factory
 */
class BranchFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates a Branch object with the given response by the VCS provider.
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    public function create()
    {
        return new $this->className;
    }
}
