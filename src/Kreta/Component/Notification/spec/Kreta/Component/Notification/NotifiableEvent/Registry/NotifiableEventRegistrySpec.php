<?php

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use Kreta\Component\Notification\NotifiableEvent\NotifiableEventInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotifiableEventRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\NotifiableEventRegistry');
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
        //Add event
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);

        //Duplicate event and therefore get the exception
        $this->shouldThrow('Kreta\Component\Notification\NotifiableEvent\Registry\ExistingNotifiableEventException')
            ->duringRegisterNotifiableEvent('testEvent', $notifiableEvent);
    }

    function it_unregisters_notifiable_event(NotifiableEventInterface $notifiableEvent)
    {
        //Add event
        $this->registerNotifiableEvent('testEvent', $notifiableEvent);

        //Unregister existing event
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
