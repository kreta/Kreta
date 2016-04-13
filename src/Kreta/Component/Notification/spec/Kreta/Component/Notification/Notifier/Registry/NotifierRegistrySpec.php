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

namespace spec\Kreta\Component\Notification\Notifier\Registry;

use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class NotifierRegistrySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class NotifierRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\Registry\NotifierRegistry');
    }

    function it_implements_notifier_registry_interface()
    {
        $this->shouldImplement('Kreta\Component\Notification\Notifier\Registry\Interfaces\NotifierRegistryInterface');
    }

    function it_returns_notifiers()
    {
        $this->getNotifiers()->shouldReturn([]);
    }

    function it_registers_notifier(NotifierInterface $notifier)
    {
        $this->registerNotifier('testNotifier', $notifier);
    }

    function it_doesnt_register_notifier_if_exists(NotifierInterface $notifier)
    {
        $this->registerNotifier('testNotifier', $notifier);

        $this->shouldThrow('Kreta\Component\Notification\Notifier\Registry\ExistingNotifierException')
            ->duringRegisterNotifier('testNotifier', $notifier);
    }

    function it_unregisters_notifier(NotifierInterface $notifier)
    {
        $this->registerNotifier('testNotifier', $notifier);

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
