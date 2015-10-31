<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\NotificationBundle;

use Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiableEventsPass;
use Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class KretaNotificationBundle.
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
