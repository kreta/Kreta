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

use Kreta\Bundle\CoreBundle\Form\Type\CommentType;

class CommentFormHandler extends AbstractFormHandler
{
    protected $successMessage = 'Comment added successfully';

    protected $errorMessage = 'Error sending comment';

    /**
     * {@inheritdoc}
     */
    protected function createForm($object, $formOptions = null)
    {
        return $this->formFactory->create(new CommentType(), $object);
    }
}
