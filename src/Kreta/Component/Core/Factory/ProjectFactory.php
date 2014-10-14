<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Project;
use Kreta\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ProjectFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class ProjectFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Project();
    }
}
