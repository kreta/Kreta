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

namespace Kreta\Notifier\Infrastructure\Symfony\EventListener;

use Kreta\SharedKernel\Projection\Projector;
use Symfony\Component\EventDispatcher\Event;

final class ProjectorEventListener
{
    private $eventHandlers;

    public function __construct(array $eventHandlers)
    {
        $this->eventHandlers = $eventHandlers;
    }

    public function onKernel(Event $event) : void
    {
        if (method_exists($event, 'isMasterRequest') && !$event->isMasterRequest()) {
            return;
        }

        Projector::instance()->register($this->eventHandlers);
    }
}
