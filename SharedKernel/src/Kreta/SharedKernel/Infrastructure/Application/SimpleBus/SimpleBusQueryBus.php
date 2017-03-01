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

use Ajgl\SimpleBus\Message\Bus\CatchReturnMessageBus;
use Kreta\SharedKernel\Application\QueryBus;

class SimpleBusQueryBus implements QueryBus
{
    private $messageBus;

    public function __construct(CatchReturnMessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle($query, &$result) : void
    {
        $this->messageBus->handle($query, $result);
    }
}
