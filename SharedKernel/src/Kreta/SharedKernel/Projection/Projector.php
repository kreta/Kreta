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

namespace Kreta\SharedKernel\Projection;

use Kreta\SharedKernel\Domain\Model\DomainEventCollection;

final class Projector
{
    private $eventHandlers;
    private static $instance = null;

    public static function instance() : self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->eventHandlers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    public function register(array $eventHandlers)
    {
        foreach ($eventHandlers as $eventHandler) {
            $this->add($eventHandler);
        }
    }

    private function add(EventHandler $eventHandler)
    {
        $this->eventHandlers[] = $eventHandler;
    }

    public function project(DomainEventCollection $events) : void
    {
        foreach ($events as $event) {
            if (isset($this->eventHandlers[get_class($event)])) {
                $this->eventHandlers[get_class($event)]->handle($event);
            }
        }
    }
}
