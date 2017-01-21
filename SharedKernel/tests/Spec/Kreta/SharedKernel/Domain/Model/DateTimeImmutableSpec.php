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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\DateTimeImmutable;
use PhpSpec\ObjectBehavior;

class DateTimeImmutableSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DateTimeImmutable::class);
    }

    function it_builds_now()
    {
        $this->beConstructedNow();
        $this->shouldHaveType(\DateTimeImmutable::class);
    }

    function it_builds_from_ymd()
    {
        $this->beConstructedFromYmd('2016-10-11');
        $this->shouldHaveType(\DateTimeImmutable::class);
    }

    function it_builds_relative()
    {
        $this->beConstructedRelative('+7 days');
        $this->shouldHaveType(\DateTimeImmutable::class);
    }
}
