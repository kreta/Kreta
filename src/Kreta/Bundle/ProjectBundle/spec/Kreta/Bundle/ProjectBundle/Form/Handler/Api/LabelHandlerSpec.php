<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Project\Factory\LabelFactory;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LabelHandlerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class LabelHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        LabelFactory $labelFactory
    )
    {
        $this->beConstructedWith(
            $formFactory,
            $manager,
            $eventDispatcher,
            $labelFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Handler\Api\LabelHandler');
    }

    function it_extends_core_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_handle_form_because_project_key_does_not_exist(LabelInterface $label, Request $request)
    {
        $this->shouldThrow(new ParameterNotFoundException('project'))
            ->during('handleForm', [$request, $label, []]);
    }

    function it_handles_form(
        Request $request,
        LabelInterface $label,
        FormFactory $formFactory,
        FormInterface $form,
        ProjectInterface $project
    )
    {
        $formFactory->create(Argument::type('\Kreta\Bundle\ProjectBundle\Form\Type\Api\LabelType'), $label, [])
            ->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $label, ['project' => $project])->shouldReturn($form);
    }
}
