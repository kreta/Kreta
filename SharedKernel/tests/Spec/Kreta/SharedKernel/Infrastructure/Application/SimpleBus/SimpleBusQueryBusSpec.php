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

namespace Spec\Kreta\SharedKernel\Infrastructure\Application\SimpleBus;

use Ajgl\SimpleBus\Message\Bus\CatchReturnMessageBus;
use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Infrastructure\Application\SimpleBus\SimpleBusQueryBus;
use PhpSpec\ObjectBehavior;

class SimpleBusQueryBusSpec extends ObjectBehavior
{
    function let(CatchReturnMessageBus $messageBus)
    {
        $this->beConstructedWith($messageBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleBusQueryBus::class);
        $this->shouldImplement(QueryBus::class);
    }

//    function it_handles_a_query(CatchReturnMessageBus $messageBus, OrganizationOfIdQuery $query)
//    {
//         It is not possible to mock variable that passes by reference
//    }
}
