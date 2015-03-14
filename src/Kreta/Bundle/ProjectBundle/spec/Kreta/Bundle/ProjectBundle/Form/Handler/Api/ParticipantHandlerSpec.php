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
use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ParticipantHandlerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class ParticipantHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        ParticipantFactory $factory,
        UserRepository $userRepository
    )
    {
        $this->beConstructedWith(
            $formFactory,
            $manager,
            $eventDispatcher,
            $context,
            $factory,
            $userRepository
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Form\Handler\Api\ParticipantHandler');
    }

    function it_extends_core_abstract_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_handle_form_because_project_key_does_not_exist(
        ParticipantInterface $participant,
        Request $request
    )
    {
        $this->shouldThrow(new ParameterNotFoundException('project'))
            ->during('handleForm', [$request, $participant, []]);
    }

    function it_handles_form(
        Request $request,
        ParticipantInterface $participant,
        FormFactory $formFactory,
        FormInterface $form,
        ProjectInterface $project
    )
    {
        $formFactory->create(
            Argument::type('\Kreta\Bundle\ProjectBundle\Form\Type\Api\ParticipantType'), $participant, []
        )->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $participant, ['project' => $project])->shouldReturn($form);
    }
}
