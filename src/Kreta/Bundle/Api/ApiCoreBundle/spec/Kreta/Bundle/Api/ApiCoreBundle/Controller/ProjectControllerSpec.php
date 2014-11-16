<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\Controller;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType;
use Kreta\Component\Core\Factory\ParticipantFactory;
use Kreta\Component\Core\Factory\ProjectFactory;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class ProjectControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\ProjectController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_projects_because_the_user_is_not_logged(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        ParamFetcher $paramFetcher
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getProjectsAction', array($paramFetcher));
    }

    function it_gets_projects(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ParamFetcher $paramFetcher,
        ViewHandler $viewHandler,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        Response $response
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $container->get('kreta_core.repository_project')
            ->shouldBeCalled()->willReturn($projectRepository);
        $paramFetcher->get('order')->shouldBeCalled()->willReturn('name');
        $paramFetcher->get('count')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('page')->shouldBeCalled()->willReturn(1);
        $projectRepository->findByParticipant($user, 'name', 10, 1)->shouldBeCalled()->willReturn(array());

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getProjectsAction($paramFetcher)->shouldReturn($response);
    }

    function it_does_not_get_project_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getProjectAction', array('project-id'));
    }

    function it_does_not_get_project_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getProjectAction', array('project-id'));
    }

    function it_gets_project(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getProjectAction('project-id')->shouldReturn($response);
    }

    function it_posts_project(
        ContainerInterface $container,
        ProjectFactory $projectFactory,
        ProjectInterface $project,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.factory_project')->shouldBeCalled()->willReturn($projectFactory);
        $projectFactory->create()->shouldBeCalled()->willReturn($project);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_core.factory_participant')->shouldBeCalled()->willReturn($participantFactory);
        $participantFactory->create($project, $user, 'ROLE_ADMIN')->shouldBeCalled()->willReturn($participant);

        $project->addParticipant($participant)->shouldBeCalled()->willReturn($project);


        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new ProjectType(), $project, array('csrf_protection' => false, 'method' => 'POST'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($project)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postProjectsAction()->shouldReturn($response);
    }

    function it_does_not_posts_project_because_there_are_some_form_errors(
        ContainerInterface $container,
        ProjectFactory $projectFactory,
        ProjectInterface $project,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.factory_project')->shouldBeCalled()->willReturn($projectFactory);
        $projectFactory->create()->shouldBeCalled()->willReturn($project);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_core.factory_participant')->shouldBeCalled()->willReturn($participantFactory);
        $participantFactory->create($project, $user, 'ROLE_ADMIN')->shouldBeCalled()->willReturn($participant);

        $project->addParticipant($participant)->shouldBeCalled()->willReturn($project);


        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new ProjectType(), $project, array('csrf_protection' => false, 'method' => 'POST'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn(array($formChild));
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn(array($formGrandChild));
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postProjectsAction()->shouldReturn($response);
    }

    function it_puts_project(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $project)->shouldBeCalled()->willReturn(true);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new ProjectType(), $project, array('csrf_protection' => false, 'method' => 'PUT'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($project)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putProjectsAction('project-id')->shouldReturn($response);
    }

    function it_does_not_puts_project_because_there_are_some_form_errors(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $project)->shouldBeCalled()->willReturn(true);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new ProjectType(), $project, array('csrf_protection' => false, 'method' => 'PUT'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn(array($formChild));
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn(array($formGrandChild));
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putProjectsAction('project-id')->shouldReturn($response);
    }
}
