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
use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType;
use Kreta\Component\Core\Factory\StatusFactory;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\StatusRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\StatusController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_statuses_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getStatusesAction', array('project-id'));
    }

    function it_does_not_get_statuses_because_the_user_has_not_the_required_grant(
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
            ->during('getStatusesAction', array('project-id'));
    }

    function it_gets_statuses(
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

        $this->getStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_get_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getStatusAction', array('project-id', 'status-id'));
    }

    function it_does_not_get_status_because_the_user_has_not_the_required_grant(
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
            ->during('getStatusAction', array('project-id', 'status-id'));
    }

    function it_does_not_get_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('getStatusAction', array('project-id', 'status-id'));
    }

    function it_gets_status(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn($status);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getStatusAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_post_status_because_the_name_is_blank(
        ContainerInterface $container,
        Request $request
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('');
        $this->shouldThrow(new BadRequestHttpException('Name should not be blank'))
            ->during('postStatusesAction', array('project-id'));
    }

    function it_does_not_post_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory_status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('postStatusesAction', array('project-id'));
    }

    function it_does_not_post_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory_status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postStatusesAction', array('project-id'));
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory_status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $status->setProject($project)->shouldBeCalled()->willReturn($status);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new StatusType(), $status, array('csrf_protection' => false, 'method' => 'POST'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($status)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_posts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory_status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $status->setProject($project)->shouldBeCalled()->willReturn($status);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new StatusType(), $status, array('csrf_protection' => false, 'method' => 'POST'))
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

        $this->postStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_put_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('putStatusesAction', array('project-id', 'status-id'));
    }

    function it_does_not_put_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putStatusesAction', array('project-id', 'status-id'));
    }

    function it_does_not_put_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('putStatusesAction', array('project-id', 'status-id'));
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
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
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn($status);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new StatusType(), $status, array('csrf_protection' => false, 'method' => 'PUT'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($status)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_puts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
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
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn($status);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new StatusType(), $status, array('csrf_protection' => false, 'method' => 'PUT'))
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

        $this->putStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_delete_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('deleteStatusesAction', array('project-id', 'status-id'));
    }

    function it_does_not_delete_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('deleteStatusesAction', array('project-id', 'status-id'));
    }

    function it_does_not_delete_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('deleteStatusesAction', array('project-id', 'status-id'));
    }

    function it_deletes_status(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('manage_status', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findOneById('status-id')->shouldBeCalled()->willReturn($status);

        $statusRepository->delete($status)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }
}
