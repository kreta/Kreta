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

use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDataTransformer;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsHandler;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterOrganizationsHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $repository,
        OrganizationSpecificationFactory $specificationFactory,
        OrganizationDataTransformer $dataTransformer
    ) {
        $this->beConstructedWith($repository, $specificationFactory, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterOrganizationsHandler::class);
    }

    function it_serializes_filtered_organizations(
        FilterOrganizationsQuery $query,
        OrganizationRepository $repository,
        Organization $organization,
        OrganizationDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->name()->shouldBeCalled()->willReturn('organization name');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$organization]);
        $dataTransformer->write($organization)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query)->shouldBeArray();
    }
}
