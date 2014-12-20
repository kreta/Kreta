<?php

namespace spec\Kreta\Bundle\WebBundle\Controller;

use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;

class UserControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\DefaultController');
    }

    /*function it_renders_landing_if_not_logged_in(ContainerInterface $container, SecurityContext $securityContext)
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn(null);

        $this->indexAction()->shouldReturn([]);
    }

    function it_renders_dashboard_if_logged_in(ContainerInterface $container, SecurityContext $securityContext,
                                               UserInterface $user)
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($user);

        $this->indexAction()->shouldReturn([]);
    }*/

}
