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

declare(strict_types=1);

namespace Kreta\Notifier\Infrastructure\Projection\Finder\Inbox;

class NotificationFinder
{
    public function all()
    {
        // en esta clase no se como hacerlo, si un finder que haga de factory
        // de los query handlers o no
        // lo unico que esta claro es que desde este tipo de metodos hay que buscar en la tabla notification_projection
        // que es la que alimentan los projectors
    }
}
