<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\FormHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IssueFormHandlerSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\FormHandler
 */
class IssueFormHandlerSpec extends ObjectBehavior
{
    function let(FormFactory $formFactory, ObjectManager $manager,
                 EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\FormHandler\IssueFormHandler');
    }

    function it_handles_form(Request $request, IssueInterface $issue, FormFactory $formFactory,
                             ParticipantInterface $participant)
    {
        $formFactory->create(Argument::type('\Kreta\Bundle\CoreBundle\Form\Type\IssueType'), $issue);
        $request->isMethod('POST')->shouldBeCalled()->willReturn(false);
        $this->handleForm($request, $issue, [$participant]);
    }
}
