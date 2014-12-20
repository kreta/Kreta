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

use Kreta\Bundle\ProjectBundle\Form\Type\ProjectType as BaseProjectType;

/**
 * Class ProjectType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class ProjectType extends BaseProjectType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
