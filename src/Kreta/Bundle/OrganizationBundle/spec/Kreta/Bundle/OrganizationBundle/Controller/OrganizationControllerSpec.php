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

namespace spec\Kreta\Bundle\OrganizationBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Organization\Form\Handler\OrganizationHandler;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Organization\Repository\OrganizationRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

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
        $this->shouldHaveType('Kreta\Bundle\OrganizationBundle\Controller\OrganizationController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_organizations(
        ContainerInterface $container,
        OrganizationRepository $organizationRepository,
        ParamFetcher $paramFetcher,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        OrganizationInterface $organization
    ) {
        $container->get('kreta_organization.repository.organization')
            ->shouldBeCalled()->willReturn($organizationRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('name');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $organizationRepository->findByParticipant($user, ['name' => 'ASC'], 10, 1)
            ->shouldBeCalled()->willReturn([$organization]);

        $this->getOrganizationsAction($paramFetcher)->shouldReturn([$organization]);
    }

    function it_gets_organization(Request $request, OrganizationInterface $organization)
    {
        $request->get('organization')->shouldBeCalled()->willReturn($organization);

        $this->getOrganizationAction($request, 'organization-id')->shouldReturn($organization);
    }

    function it_posts_organization(
        ContainerInterface $container,
        Request $request,
        OrganizationHandler $organizationHandler,
        OrganizationInterface $organization
    ) {
        $container->get('kreta_organization.form_handler.organization')
            ->shouldBeCalled()->willReturn($organizationHandler);
        $organizationHandler->processForm($request)->shouldBeCalled()->willReturn($organization);

        $this->postOrganizationsAction($request)->shouldReturn($organization);
    }

    function it_puts_organization(
        ContainerInterface $container,
        OrganizationInterface $organization,
        Request $request,
        OrganizationHandler $organizationHandler
    ) {
        $container->get('kreta_organization.form_handler.organization')
            ->shouldBeCalled()->willReturn($organizationHandler);
        $request->get('organization')->shouldBeCalled()->willReturn($organization);
        $organizationHandler->processForm($request, $organization, ['method' => 'PUT'])
            ->shouldBeCalled()->willReturn($organization);

        $this->putOrganizationsAction($request, 'organization-id')->shouldReturn($organization);
    }
}
