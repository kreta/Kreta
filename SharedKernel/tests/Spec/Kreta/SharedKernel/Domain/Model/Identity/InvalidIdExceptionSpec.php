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

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\InvalidIdException;
use PhpSpec\ObjectBehavior;

class InvalidIdExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidIdException::class);
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType(InvalidIdException::class);
    }
}
