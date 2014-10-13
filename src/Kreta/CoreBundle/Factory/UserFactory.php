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

use Kreta\CoreBundle\Model\User;
use Kreta\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class UserFactory.
 *
 * @package Kreta\CoreBundle\Factory
 */
class UserFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new User();
    }
}
