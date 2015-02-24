<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\TimeTrackingBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\TimeTracking\Factory\TimeEntryFactory;
use Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TimeEntryHandlerSpec.
 *
 * @package spec\Kreta\Bundle\TimeTrackingBundle\Form\Handler
 */
class TimeEntryHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        TimeEntryFactory $factory
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\TimeTrackingBundle\Form\Handler\TimeEntryHandler');
    }

    function it_extends_abstract_form_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_handle_form_because_issue_key_does_not_exist(TimeEntryInterface $timeEntry, Request $request)
    {
        $this->shouldThrow(new ParameterNotFoundException('issue'))
            ->during('handleForm', [$request, $timeEntry, []]);
    }

    function it_handles_form(
        Request $request,
        TimeEntryInterface $timeEntry,
        IssueInterface $issue,
        FormFactory $formFactory,
        FormInterface $form
    )
    {
        $formFactory->create(Argument::type('Kreta\Bundle\TimeTrackingBundle\Form\Type\TimeEntryType'), $timeEntry, [])
            ->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $timeEntry, ['issue' => $issue])->shouldReturn($form);
    }
}
