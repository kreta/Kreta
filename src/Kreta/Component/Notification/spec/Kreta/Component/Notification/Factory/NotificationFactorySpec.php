<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NotificationFactorySpec.
 *
 * @package spec\Kreta\Component\Notification\Factory
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
