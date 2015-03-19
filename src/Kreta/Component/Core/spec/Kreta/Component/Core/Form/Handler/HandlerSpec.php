<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HandlerSpec.
 *
 * @package spec\Kreta\Component\Core\Form\Handler
 */
class HandlerSpec extends ObjectBehavior
{
    function let(FormFactoryInterface $formFactory, ObjectManager $manager)
    {
        $object = Argument::type('Object');
        $this->beConstructedWith($formFactory, $manager, 'kreta_dummy_type');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Handler\Handler');
    }

    function it_implements_handler_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Form\Handler\Interfaces\HandlerInterface');
    }

    function it_processes_form_returning_form_data(
        Request $request,
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form
    )
    {
        $formFactory->createNamedBuilder('', 'kreta_dummy_type', null, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $form->getData()->shouldBeCalled()->willReturn($this->object);

        $this->processForm($request)->shouldReturn($this->object);
    }

    function it_processes_form_returning_object(
        Request $request,
        ProjectInterface $project,
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form
    )
    {
        $formFactory->createNamedBuilder('', 'kreta_dummy_type', $project, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);

        $this->processForm($request, $project)->shouldReturn($project);
    }

    function it_does_not_handle_form_when_the_form_is_invalid(
        Request $request,
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form,
        FormError $formError,
        FormInterface $child
    )
    {
        $formFactory->createNamedBuilder('', 'kreta_dummy_type', null, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);

        $form->getErrors()->shouldBeCalled()->willReturn([$formError]);
        $formError->getMessage()->shouldBeCalled()->willReturn('Form error');
        $form->all()->shouldBeCalled()->willReturn([$child]);
        $child->isValid()->shouldBeCalled()->willReturn(false);
        $child->getName()->shouldBeCalled()->willReturn('Child form error');
        $child->getErrors()->shouldBeCalled()->willReturn([]);
        $child->all()->shouldBeCalled()->willReturn([]);

        $this->shouldThrow(new InvalidFormException(['Form error', 'Child form error' => []]))
            ->during('handleForm', [$request]);
    }
    
    function it_handles_form(
        Request $request,
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form,
        FileBag $fileBag,
        ObjectManager $manager
    )
    {
        $formFactory->createNamedBuilder('', 'kreta_dummy_type', null, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(false);
        $request->isMethod('PUT')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $form->getData()->shouldBeCalled()->willReturn($this->object);
        $request->files = $fileBag;
        $manager->persist($this->object)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();
        
        $this->handleForm($request)->shouldReturn($form);
    }
}
