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

namespace Spec\Kreta\TaskManager\Application\Query\Organization;

use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdQuery;
use PhpSpec\ObjectBehavior;

class OwnerOfIdQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('organization-id', 'owner-id', 'user-id');
        $this->shouldHaveType(OwnerOfIdQuery::class);
        $this->organizationId()->shouldReturn('organization-id');
        $this->ownerId()->shouldReturn('owner-id');
        $this->userId()->shouldReturn('user-id');
    }
}
