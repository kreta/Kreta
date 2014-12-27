<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Form\Handler;

use Kreta\Bundle\ApiBundle\Form\Type\StatusTransitionType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class StatusTransitionHandler.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusTransitionHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        if (!array_key_exists('states', $formOptions)) {
            throw new ParameterNotFoundException('states');
        }

        $states = $formOptions['states'];
        unset($formOptions['states']);

        return $this->formFactory->create(new StatusTransitionType($states), $object, $formOptions);
    }
}
