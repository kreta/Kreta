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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use PhpSpec\ObjectBehavior;

class OrganizationIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationId::class);
    }

    function it_extends_id()
    {
        $this->shouldHaveType(Id::class);
    }

    function it_generates()
    {
        $this->beConstructedGenerate();

        $this::generate()->shouldReturnAnInstanceOf(OrganizationId::class);
    }
}
