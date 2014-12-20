<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\FormHandler;

use Kreta\Bundle\CommentBundle\Form\Type\CommentType;

/**
 * Class CommentFormHandler.
 *
 * @package Kreta\Bundle\WebBundle\FormHandler
 */
class CommentFormHandler extends AbstractFormHandler
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
    protected function createForm($object, array $formOptions = [])
    {
        return $this->formFactory->create(new CommentType(), $object, $formOptions);
    }
}
