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
    /**
     * @param $object
     * @param $formOptions
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function createForm($object, $formOptions = null)
    {
        return $this->formFactory->create(new CommentType(), $object);
    }

    /**
     * Handles object
     *
     * @param \Kreta\Component\Core\Model\Interfaces\CommentInterface $object
     * @param array                                                   $helpers
     */
    public function handleObject($object, $helpers = [])
    {
        $object->setWrittenBy($helpers['user']);
        $object->setIssue($helpers['issue']);

        parent::handleObject($object, $helpers);
    }


} 
