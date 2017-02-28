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

namespace Kreta\SharedKernel\Infrastructure\Application\SimpleBus;

use Kreta\SharedKernel\Application\CommandBus;
use SimpleBus\Message\Bus\MessageBus;

class SimpleBusCommandBus implements CommandBus
{
    private $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle($command) : void
    {
        $this->messageBus->handle($command);
    }
}
