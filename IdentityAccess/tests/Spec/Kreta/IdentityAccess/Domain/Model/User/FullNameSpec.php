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

namespace Spec\Kreta\IdentityAccess\Domain\Model\User;

use Kreta\IdentityAccess\Domain\Model\User\FirstNameEmptyException;
use PhpSpec\ObjectBehavior;

class FullNameSpec extends ObjectBehavior
{
    function it_does_not_create_full_name_with_empty_first_name()
    {
        $this->beConstructedWith('', '');
        $this->shouldThrow(FirstNameEmptyException::class)->duringInstantiation();
    }

    function it_creates_with_empty_last_name()
    {
        $this->beConstructedWith('Kreta', '');
        $this->firstName()->shouldReturn('Kreta');
        $this->lastName()->shouldReturn('');
        $this->fullName()->shouldReturn('Kreta');
        $this->__toString()->shouldReturn('Kreta');
    }

    function it_creates()
    {
        $this->beConstructedWIth('Kreta', 'Info');
        $this->firstName()->shouldReturn('Kreta');
        $this->lastName()->shouldReturn('Info');
        $this->fullName()->shouldReturn('Kreta Info');
        $this->__toString()->shouldReturn('Kreta Info');
    }
}
