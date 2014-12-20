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

use Kreta\Bundle\IssueBundle\Form\Type\IssueType as BaseIssueType;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class IssueType extends BaseIssueType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
