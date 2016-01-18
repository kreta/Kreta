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

namespace spec\Kreta\Component\Notification\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NotificationFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class NotificationFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Notification\Model\Notification');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Factory\NotificationFactory');
    }

    function it_creates_notification()
    {
        $this->create()
            ->shouldReturnAnInstanceOf('Kreta\Component\Notification\Model\Interfaces\NotificationInterface');
    }
}
