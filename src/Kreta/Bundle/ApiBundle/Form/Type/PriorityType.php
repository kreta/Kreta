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

use Kreta\Bundle\IssueBundle\Form\Type\PriorityType as BasePriorityType;

/**
 * Class PriorityType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class PriorityType extends BasePriorityType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
