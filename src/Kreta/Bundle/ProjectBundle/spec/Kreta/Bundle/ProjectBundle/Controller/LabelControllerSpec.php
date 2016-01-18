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

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\LabelRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LabelControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_labels(
        ContainerInterface $container,
        Request $request,
        LabelRepository $labelRepository,
        ParamFetcher $paramFetcher,
        ProjectInterface $project,
        LabelInterface $label
    )
    {
        $container->get('kreta_project.repository.label')->shouldBeCalled()->willReturn($labelRepository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('java');
        $labelRepository->findByProject($project, 10, 1, 'java')->shouldBeCalled()->willReturn([$label]);

        $this->getLabelsAction($request, 'project-id', $paramFetcher)->shouldReturn([$label]);
    }

    function it_posts_label(
        ContainerInterface $container,
        Request $request,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        LabelInterface $label
    )
    {
        $container->get('kreta_project.form_handler.label')->shouldBeCalled()->willReturn($handler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($label);

        $this->postLabelsAction($request, 'project-id')->shouldReturn($label);
    }

    function it_deletes_label(ContainerInterface $container, LabelRepository $labelRepository, LabelInterface $label)
    {
        $container->get('kreta_project.repository.label')->shouldBeCalled()->willReturn($labelRepository);
        $labelRepository->find('label-id', false)->shouldBeCalled()->willReturn($label);
        $labelRepository->remove($label)->shouldBeCalled();

        $this->deleteLabelsAction('project-id', 'label-id');
    }
}
