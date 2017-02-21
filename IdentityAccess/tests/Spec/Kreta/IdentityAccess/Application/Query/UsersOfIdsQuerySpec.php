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

namespace Spec\Kreta\IdentityAccess\Application\Query;

use Kreta\IdentityAccess\Application\Query\UsersOfIdsQuery;
use PhpSpec\ObjectBehavior;

class UsersOfIdsQuerySpec extends ObjectBehavior
{
    function it_creates_a_query()
    {
        $this->beConstructedWith(['user-id', 'user-id-2']);

        $this->shouldHaveType(UsersOfIdsQuery::class);

        $this->ids()->shouldReturn(['user-id', 'user-id-2']);
    }
}
