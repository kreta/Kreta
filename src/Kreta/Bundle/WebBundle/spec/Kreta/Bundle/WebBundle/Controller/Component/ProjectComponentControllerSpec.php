<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\Controller\Component;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectComponentControllerSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\Controller
 */
class ProjectComponentControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\Component\ProjectComponentController');
    }

    function it_renders_users_projects(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TwigEngine $engine
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_project.repository.project')
            ->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findByParticipant($user)->shouldBeCalled()->willReturn([$project]);

        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $engine->renderResponse('KretaWebBundle:Component/Project:user.html.twig', ['projects' => [$project]]);

        $this->userAction();
    }
}
