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

namespace spec\Kreta\Bundle\WebBundle\Controller\Api;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Organization\Repository\OrganizationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Spec file of OrganizationController class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\Api\OrganizationController');
    }

    function it_extends_symfony_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_organization(
        ContainerInterface $container,
        OrganizationRepository $repository,
        OrganizationInterface $organization
    ) {
        $container->get('kreta_organization.repository.organization')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['slug' => 'organization-slug'], false)->shouldBeCalled()->willReturn($organization);

        $this->getOrganizationAction('organization-slug')->shouldReturn($organization);
    }
}
