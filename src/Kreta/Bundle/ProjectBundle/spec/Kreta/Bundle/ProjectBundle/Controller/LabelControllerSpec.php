<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\LabelRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class LabelControllerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Controller
 */
class LabelControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\LabelController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_gets_labels(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        LabelRepository $labelRepository,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $context,
        ProjectInterface $project,
        LabelInterface $label
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context);

        $container->get('kreta_project.repository.label')->shouldBeCalled()->willReturn($labelRepository);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('java');
        $labelRepository->findByProject($project, 10, 1, 'java')
            ->shouldBeCalled()->willReturn([$label]);

        $this->getLabelsAction('project-id', $paramFetcher)->shouldReturn([$label]);
    }

    function it_does_not_get_labels_because_the_user_has_not_the_required_grant(
        LabelRepository $labelRepository,
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_project.repository.label')->shouldBeCalled()->willReturn($labelRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getLabelsAction', ['project-id', $paramFetcher]);
    }

    function it_does_not_post_label_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_label', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postLabelsAction', ['project-id']);
    }

    function it_posts_label(
        ContainerInterface $container,
        Request $request,
        ProjectRepository $projectRepository,
        SecurityContextInterface $securityContext,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        LabelInterface $label
    )
    {
        $project = $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_label'
        );

        $container->get('kreta_project.form_handler.label')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($label);

        $this->postLabelsAction('project-id')->shouldReturn($label);
    }

    function it_does_not_delete_label_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'delete_label', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('deleteLabelsAction', ['project-id', 'label-id']);
    }

    function it_deletes_label(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        LabelRepository $labelRepository,
        LabelInterface $label
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'delete_label');
        $container->get('kreta_project.repository.label')->shouldBeCalled()->willReturn($labelRepository);
        $labelRepository->find('label-id', false)->shouldBeCalled()->willReturn($label);
        $labelRepository->remove($label)->shouldBeCalled();

        $this->deleteLabelsAction('project-id', 'label-id');
    }

    protected function getProjectIfAllowedSpec(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id', false)->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $project)->shouldBeCalled()->willReturn($result);

        return $project;
    }
}
