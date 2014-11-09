<?php

namespace spec\Kreta\Component\Notification\Notifier\Registry;

use Kreta\Component\Notification\Notifier\NotifierInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotifierRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\Registry\NotifierRegistry');
    }

    function it_returns_notifiers()
    {
        $this->getNotifiers()->shouldReturn(array());
    }

    function it_registers_notifier(NotifierInterface $notifier)
    {
        $this->registerNotifier('testNotifier', $notifier);
    }

    function it_doesnt_register_notifier_if_exists(NotifierInterface $notifier)
    {
        //Add notifier
        $this->registerNotifier('testNotifier', $notifier);

        //Duplicate notifier and therefore get the exception
        $this->shouldThrow('Kreta\Component\Notification\Notifier\Registry\ExistingNotifierException')
            ->duringRegisterNotifier('testNotifier', $notifier);
    }

    function it_unregisters_notifier(NotifierInterface $notifier)
    {
        //Add notifier
        $this->registerNotifier('testNotifier', $notifier);

        //Unregister existing notifier
        $this->unregisterNotifier('testNotifier');
    }

    function it_throws_exception_if_notifier_doesnt_exist()
    {
        $this->shouldThrow('Kreta\Component\Notification\Notifier\Registry\NonExistingNotifierException')
            ->duringUnregisterNotifier('unexistingNotifier');
    }

    function it_checks_if_notifier_exists(NotifierInterface $notifier)
    {
        $this->hasNotifier('testNotifier')->shouldReturn(false);

        $this->registerNotifier('testNotifier', $notifier);

        $this->hasNotifier('testNotifier')->shouldReturn(true);
    }

    function it_returns_notifier(NotifierInterface $notifier)
    {
        $this->registerNotifier('testNotifier', $notifier);
        $this->getNotifier('testNotifier')->shouldReturn($notifier);
    }

    function it_throws_exception_if_it_cannot_found_event()
    {
        $this->shouldThrow('Kreta\Component\Notification\Notifier\Registry\NonExistingNotifierException')
            ->duringGetNotifier('unexistingNotifier');
    }
}
