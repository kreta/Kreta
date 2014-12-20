<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Form\Type;

use Kreta\Bundle\UserBundle\Form\Type\UserType as BaserUserType;

/**
 * Class UserType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class UserType extends BaserUserType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
