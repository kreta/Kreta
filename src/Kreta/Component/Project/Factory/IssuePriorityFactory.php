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

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class IssuePriorityFactory.
 *
 * @package Kreta\Component\Project\Factory
 */
class IssuePriorityFactory
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
     * Creates an instance of issue priority.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     * @param string                                                     $name    The name
     * @param string                                                     $color   The color
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface
     */
    public function create(ProjectInterface $project, $name, $color)
    {
        $issuePriority = new $this->className();

        return $issuePriority
            ->setProject($project)
            ->setColor($color)
            ->setName($name);
    }
}
