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

namespace spec\Kreta\Component\Core\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
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
    /**
     * The object stub.
     *
     * @var Object
     */
    protected $object;

    function let(FormFactoryInterface $formFactory, ObjectManager $manager)
    {
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
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        FormInterface $form
    )
    {
        $formFactory->createNamedBuilder('', 'kreta_dummy_type', $this->object, [])
            ->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->shouldBeCalled()->willReturn($form);

        $this->processForm($request, $this->object)->shouldReturn($this->object);
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
        $request->isMethod('PUT')->shouldBeCalled()->willReturn(false);
        $request->isMethod('PATCH')->shouldBeCalled()->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $form->getData()->shouldBeCalled()->willReturn($this->object);
        $request->files = $fileBag;
        $manager->persist($this->object)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->handleForm($request)->shouldReturn($form);
    }
}
