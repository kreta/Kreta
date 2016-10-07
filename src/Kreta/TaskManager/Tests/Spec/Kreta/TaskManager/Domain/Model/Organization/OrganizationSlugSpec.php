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

use Kreta\SharedKernel\Domain\Model\Slug;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSlug;
use PhpSpec\ObjectBehavior;

class OrganizationSlugSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Organization name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationSlug::class);
        $this->shouldHaveType(Slug::class);
    }

    function it_gets_slug()
    {
        $this->slug()->shouldReturn('organization-name');
    }
}
