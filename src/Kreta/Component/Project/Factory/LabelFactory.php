<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class LabelFactory.
 *
 * @package Kreta\Component\Project\Factory
 */
class LabelFactory
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
     * Creates an instance of an label.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     * @param string                                                     $name    The name
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface
     */
    public function create(ProjectInterface $project, $name)
    {
        $label = new $this->className();

        return $label
            ->setProject($project)
            ->setName($name);
    }
}
