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

use Kreta\SharedKernel\Domain\Model\Slug;
use PhpSpec\ObjectBehavior;

class SlugSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Some plain text');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Slug::class);
    }

    function it_gets_slug()
    {
        $this->slug()->shouldReturn('some-plain-text');
        $this->__toString()->shouldReturn('some-plain-text');
    }
}
