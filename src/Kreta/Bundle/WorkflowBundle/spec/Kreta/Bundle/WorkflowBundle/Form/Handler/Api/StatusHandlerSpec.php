<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Workflow\Factory\StatusFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusHandlerSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Form\Handler\Api
 */
class StatusHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        StatusFactory $statusFactory
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher, $statusFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Form\Handler\Api\StatusHandler');
    }

    function it_extends_core_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_handles_form(Request $request, StatusInterface $status, FormFactory $formFactory, FormInterface $form)
    {
        $formFactory->create(
            Argument::type('Kreta\Bundle\WorkflowBundle\Form\Type\Api\StatusType'), $status, []
        )->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $status, [])->shouldReturn($form);
    }

    function it_handles_form_without_object_and_without_workflow_option(Request $request)
    {
        $this->shouldThrow(new ParameterNotFoundException('workflow'))->during('handleForm', [$request]);
    }

    function it_handles_form_without_object(
        Request $request,
        FormFactory $formFactory,
        FormInterface $form,
        WorkflowInterface $workflow
    )
    {
        $formFactory->create(
            Argument::type('Kreta\Bundle\WorkflowBundle\Form\Type\Api\StatusType'), null, []
        )->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, null, ['workflow' => $workflow])->shouldReturn($form);
    }
}
