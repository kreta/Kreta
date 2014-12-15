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

use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType;
use Kreta\Bundle\WebBundle\FormHandler\AbstractFormHandler;

/**
 * Class StatusHandler.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Handler
 */
class StatusHandler extends AbstractFormHandler
{
    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        return $this->formFactory->create(new StatusType(), $object, $formOptions);
    }
}
