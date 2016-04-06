<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Component\Issue\Factory;

/**
 * Class BaseFactory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ResolutionFactory
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
     * Creates an instance of an entity.
     *
     * @return object
     */
    public function create()
    {
        return new $this->className();
    }
}
