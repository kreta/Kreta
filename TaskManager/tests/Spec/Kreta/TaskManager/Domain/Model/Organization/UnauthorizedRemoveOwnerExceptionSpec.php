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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedRemoveOwnerException;
use PhpSpec\ObjectBehavior;

class UnauthorizedRemoveOwnerExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UnauthorizedRemoveOwnerException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Organization must need one owner, at least');
    }
}
