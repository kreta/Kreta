<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Form\Handler;

use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType;
use Kreta\Bundle\WebBundle\FormHandler\IssueFormHandler as BaseIssueFormHandler;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class IssueHandler.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Handler
 */
class IssueHandler extends BaseIssueFormHandler
{
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
