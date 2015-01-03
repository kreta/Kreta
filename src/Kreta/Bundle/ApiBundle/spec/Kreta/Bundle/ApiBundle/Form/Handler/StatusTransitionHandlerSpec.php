<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusTransitionHandlerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusTransitionHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Form\Handler\StatusTransitionHandler');
    }

    function it_extends_core_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_handle_form_because_states_key_does_not_exist(
        StatusTransitionInterface $statusTransition,
        Request $request
    )
    {
        $this->shouldThrow(new ParameterNotFoundException('states'))
            ->during('handleForm', [$request, $statusTransition, []]);
    }

    function it_handles_form(
        Request $request,
        StatusTransitionInterface $statusTransition,
        FormFactory $formFactory,
        FormInterface $form
    )
    {
        $formFactory->create(
            Argument::type('\Kreta\Bundle\ApiBundle\Form\Type\StatusTransitionType'),
            $statusTransition,
            []
        )->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $statusTransition, ['states' => [$statusTransition]])->shouldReturn($form);
    }
}
