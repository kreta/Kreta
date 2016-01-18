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

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NotifiableEventRegistrySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class NotifiableEventRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\NotifiableEventRegistry');
    }

    function it_implements_notifiable_event_interface()
    {
        $this->shouldImplement(
            'Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces\NotifiableEventRegistryInterface'
        );
    }

    function it_returns_notifiable_events()
    {
        $this->getNotifiableEvents()->shouldReturn([]);
    }

    function it_registers_notifiable_event(NotifiableEventInterface $notifiableEvent)
    {
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);
    }

    function it_doesnt_register_notifiable_event_if_exists(NotifiableEventInterface $notifiableEvent)
    {
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);

        $this->shouldThrow('Kreta\Component\Notification\NotifiableEvent\Registry\ExistingNotifiableEventException')
            ->duringRegisterNotifiableEvent('testEvent', $notifiableEvent);
    }

    function it_unregisters_notifiable_event(NotifiableEventInterface $notifiableEvent)
    {
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);

        $this->unregisterNotifiableEvent('testEvent');
    }

    function it_throws_exception_if_notifiable_event_doesnt_exist()
    {
        $this->shouldThrow('Kreta\Component\Notification\NotifiableEvent\Registry\NonExistingNotifiableEventException')
            ->duringUnregisterNotifiableEvent('unexistingEvent');
    }

    function it_checks_if_notifiable_event_exists(NotifiableEventInterface $notifiableEvent)
    {
        $this->hasNotifiableEvent('testEvent')->shouldReturn(false);

        $this->registerNotifiableEvent('testEvent', $notifiableEvent);

        $this->hasNotifiableEvent('testEvent')->shouldReturn(true);
    }

    function it_returns_notifiable_event(NotifiableEventInterface $notifiableEvent)
    {
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);
        $this->getNotifiableEvent('testEvent')->shouldReturn($notifiableEvent);
    }

    function it_throws_exception_if_it_cannot_found_event()
    {
        $this->shouldThrow('Kreta\Component\Notification\NotifiableEvent\Registry\NonExistingNotifiableEventException')
            ->duringGetNotifiableEvent('unexistingEvent');
    }
}
