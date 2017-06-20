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

namespace Spec\Kreta\Notifier\Application;

use Kreta\Notifier\Application\GetDomainEventsQuery;
use PhpSpec\ObjectBehavior;

class GetDomainEventsQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith(1, 25);
        $this->shouldHaveType(GetDomainEventsQuery::class);
        $this->page()->shouldReturn(1);
        $this->pageSize()->shouldReturn(25);
        $this->since()->shouldReturn(null);
    }

    function it_can_be_created_since()
    {
        $this->beConstructedWith(1, 25, '2017-06-20');
        $this->shouldHaveType(GetDomainEventsQuery::class);
        $this->page()->shouldReturn(1);
        $this->pageSize()->shouldReturn(25);
        $this->since()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}
