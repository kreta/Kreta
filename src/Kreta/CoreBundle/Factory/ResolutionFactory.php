<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Factory;

use Kreta\CoreBundle\Factory\Abstracts\AbstractFactory;
use Kreta\CoreBundle\Model\Resolution;

/**
 * Class ResolutionFactory.
 *
 * @package Kreta\CoreBundle\Factory
 */
class ResolutionFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Resolution();
    }
}
