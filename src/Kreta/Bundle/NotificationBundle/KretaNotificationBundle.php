<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\NotificationBundle;

use Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiableEventsPass;
use Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class KretaNotificationBundle.
 *
 * @package Kreta\NotificationBundle
 */
class KretaNotificationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterNotifiersPass());
        $container->addCompilerPass(new RegisterNotifiableEventsPass());
    }
}
