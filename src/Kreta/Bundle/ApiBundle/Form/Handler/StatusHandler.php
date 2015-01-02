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

use Kreta\Bundle\ApiBundle\Form\Type\StatusType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;

/**
 * Class StatusHandler.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        return $this->formFactory->create(new StatusType(), $object, $formOptions);
    }
}
