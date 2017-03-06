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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationNameEmptyException;
use PhpSpec\ObjectBehavior;

class OrganizationNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Organization name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationName::class);
    }

    function it_does_not_allow_empty_names()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(OrganizationNameEmptyException::class)->duringInstantiation();
    }

    function it_returns_name()
    {
        $this->name()->shouldReturn('Organization name');
        $this->__toString()->shouldReturn('Organization name');
    }
}
