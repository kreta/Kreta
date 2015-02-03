<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CommentBundle\Form\Type\Api;

use Kreta\Bundle\CommentBundle\Form\Type\CommentType as BaseCommentType;

/**
 * Class CommentType.
 *
 * @package Kreta\Bundle\CommentBundle\Form\Type\Api
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
