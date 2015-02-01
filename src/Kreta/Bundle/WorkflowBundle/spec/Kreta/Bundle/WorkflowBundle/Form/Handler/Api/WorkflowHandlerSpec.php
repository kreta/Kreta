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
use Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class WorkflowHandlerSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Form\Handler\Api
 */
class WorkflowHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        WorkflowFactory $workflowFactory
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher, $context, $workflowFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Form\Handler\Api\WorkflowHandler');
    }

    function it_extends_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_process_form_and_throws_invalid_form_exception(
        Request $request,
        WorkflowInterface $workflow,
        FormFactory $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild
    )
    {
        $this->handleFormSpec($request, $formFactory, $form, $workflow);
        $form->isValid()->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(
            new InvalidFormException($this->getFormErrors($form, $error, $formChild, $formGrandChild))
        )->during('processForm', [$request, $workflow, []]);
    }

    function it_processes_form(
        Request $request,
        FormFactory $formFactory,
        FormInterface $form,
        WorkflowInterface $workflow
    )
    {
        $this->handleFormSpec($request, $formFactory, $form, $workflow);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $this->processForm($request, $workflow, [])->shouldReturn($workflow);
    }

    function it_processes_form_without_workflow(
        Request $request,
        FormFactory $formFactory,
        FormInterface $form
    )
    {
        $this->handleFormSpec($request, $formFactory, $form);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $form->getData()->shouldBeCalled()->willReturn('form data');
        $this->processForm($request)->shouldReturn('form data');
    }

    function it_handles_form(
        Request $request,
        FormFactory $formFactory,
        FormInterface $form,
        WorkflowInterface $workflow
    )
    {
        $this->handleFormSpec($request, $formFactory, $form, $workflow);
    }

    function it_handles_form_without_workflow(Request $request, FormFactory $formFactory, FormInterface $form)
    {
        $this->handleFormSpec($request, $formFactory, $form);
    }

    protected function handleFormSpec(
        Request $request,
        FormFactory $formFactory,
        FormInterface $form = null,
        WorkflowInterface $workflow = null
    )
    {
        $formFactory->create(Argument::type('\Kreta\Bundle\WorkflowBundle\Form\Type\Api\WorkflowType'), $workflow, [])
            ->shouldBeCalled()->willReturn($form);
        
        $this->handleForm($request, $workflow)->shouldReturn($form);
    }

    protected function getFormErrors(
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild
    )
    {
        $form->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn([$formChild]);
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn([$formGrandChild]);
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);

        return ['error message', 'form child name' => ['error message']];
    }
}
