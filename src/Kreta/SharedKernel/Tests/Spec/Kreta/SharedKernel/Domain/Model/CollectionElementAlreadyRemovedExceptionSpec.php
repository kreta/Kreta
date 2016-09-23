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

use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyRemovedException;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class CollectionElementAlreadyRemovedExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CollectionElementAlreadyRemovedException::class);
    }

    function it_extends_exception()
    {
        $this->shouldHaveType(Exception::class);
    }
}
