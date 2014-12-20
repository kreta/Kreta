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

use Kreta\Bundle\IssueBundle\Form\Type\IssueType;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class IssueFormHandler.
 *
 * @package Kreta\Bundle\WebBundle\FormHandler
 */
class IssueFormHandler extends AbstractFormHandler
{
    /**
     * {@inheritdoc}
     */
    protected $successMessage = 'Issue saved successfully';

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'Error saving issue';

    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        if (!array_key_exists('participants', $formOptions)) {
            throw new ParameterNotFoundException('participants');
        }

        $participants = $formOptions['participants'];
        unset($formOptions['participants']);

        return $this->formFactory->create(new IssueType($participants), $object, $formOptions);
    }
}
