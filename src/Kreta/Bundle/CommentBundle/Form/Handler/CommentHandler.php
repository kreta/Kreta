<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CommentBundle\Form\Handler;

use Kreta\Bundle\CommentBundle\Form\Type\CommentType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;

/**
 * Class CommentHandler.
 *
 * @package Kreta\Bundle\CommentBundle\FormHandler
 */
class CommentHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    protected $successMessage = 'Comment added successfully';

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'Error sending comment';

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->create(new CommentType(), $object, $formOptions);
    }
}
