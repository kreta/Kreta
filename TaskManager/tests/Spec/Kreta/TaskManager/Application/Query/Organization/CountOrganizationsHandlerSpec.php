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

use Kreta\TaskManager\Application\Query\Organization\CountOrganizationsHandler;
use Kreta\TaskManager\Application\Query\Organization\CountOrganizationsQuery;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountOrganizationsHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, OrganizationSpecificationFactory $specificationFactory)
    {
        $this->beConstructedWith($repository, $specificationFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountOrganizationsHandler::class);
    }

    function it_counts_organizations(CountOrganizationsQuery $query, OrganizationRepository $repository)
    {
        $query->name()->shouldBeCalled()->willReturn('organization name');
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(2);
        $this->__invoke($query)->shouldReturn(2);
    }
}
