<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Form\Type;

use Kreta\Bundle\WebBundle\Form\Type\CommentType as BaseCommentType;

/**
 * Class CommentType.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class CommentType extends BaseCommentType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
