<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Controller\Abstracts;

use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\StatusTransitionRepository;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Abstract class AbstractRestControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller\Abstracts
 */
abstract class AbstractRestControllerSpec extends ObjectBehavior
{
    protected function getProjectIfExist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project = null
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id')->shouldBeCalled()->willReturn($project);
    }

    protected function getProjectIfAllowed(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $project)->shouldBeCalled()->willReturn($result);
    }

    protected function getWorkflowIfExist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow = null
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);
        $workflowRepository->find('workflow-id')->shouldBeCalled()->willReturn($workflow);
    }

    protected function getWorkflowIfAllowed(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);
        $workflowRepository->find('workflow-id')->shouldBeCalled()->willReturn($workflow);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $workflow)->shouldBeCalled()->willReturn($result);

        return $workflow;
    }

    protected function getFormErrors(
        ContainerInterface $container,
        Request $request,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        Response $response,
        ViewHandler $viewHandler,
        AbstractHandler $formHandler,
        $resource,
        $method = 'POST'
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $formHandler->handleForm($request, $resource, ['csrf_protection' => false, 'method' => $method])
            ->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn([$formChild]);
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn([$formGrandChild]);
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);
    }

    protected function processForm(
        ContainerInterface $container,
        Request $request,
        FormInterface $form,
        ViewHandler $viewHandler,
        AbstractHandler $formHandler,
        Response $response,
        $resource,
        $method = 'POST'
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $formHandler->handleForm($request, $resource, ['csrf_protection' => false, 'method' => $method])
            ->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);
    }

    protected function getStatusIfAllowed(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        $status = null,
        $grant = 'view',
        $result = true
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, $grant, $result);

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id')->shouldBeCalled()->willReturn($status);
    }

    protected function getTransitionIfAllowed(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        $transition = null,
        $grant = 'view',
        $result = true
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, $grant, $result);

        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id')->shouldBeCalled()->willReturn($transition);

        return $transition;
    }

    protected function getCurrentUser(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user = null
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
    }
}
