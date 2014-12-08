<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\View\ViewHandler;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\StatusRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Abstract class AbstractRestControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts
 */
abstract class AbstractRestControllerSpec extends ObjectBehavior
{
    protected function getProjectIfExist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project = null
    )
    {
        $container->get('kreta_core.repository.project')->shouldBeCalled()->willReturn($projectRepository);
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
        $container->get('kreta_core.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $project)->shouldBeCalled()->willReturn($result);
    }

    protected function getFormErrors(
        ContainerInterface $container,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response,
        AbstractType $formType,
        $object,
        $requestMethod = 'POST'
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn($requestMethod);
        $formFactory->create($formType, $object, ['csrf_protection' => false, 'method' => $requestMethod])
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
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
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response,
        AbstractType $formType,
        $object,
        $requestMethod = 'POST'
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn($requestMethod);
        $formFactory->create($formType, $object, ['csrf_protection' => false, 'method' => $requestMethod])
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($object)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);
    }

    protected function getStatusIfAllowed(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        $status = null,
        $grant = 'view',
        $result = true
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, $grant, $result);

        $container->get('kreta_core.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id')->shouldBeCalled()->willReturn($status);
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
