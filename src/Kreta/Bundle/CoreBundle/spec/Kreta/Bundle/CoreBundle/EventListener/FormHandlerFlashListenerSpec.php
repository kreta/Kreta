<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\EventListener;

use Kreta\Bundle\CoreBundle\Event\FormHandlerEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FormHandlerFlashListenerSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\EventListener
 */
class FormHandlerFlashListenerSpec extends ObjectBehavior
{
    function let(Session $session)
    {
        $this->beConstructedWith($session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\EventListener\FormHandlerFlashListener');
    }

    function it_add_flash_message(Session $session, FlashBagInterface $flashBag, FormHandlerEvent $event)
    {
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBag);
        $event->getType()->shouldBeCalled()->willReturn('success');
        $event->getMessage()->shouldBeCalled()->willReturn('Saved successfully');
        $flashBag->add('success', 'Saved successfully')->shouldBeCalled();

        $this->onFormHandlerEvent($event);
    }
}
