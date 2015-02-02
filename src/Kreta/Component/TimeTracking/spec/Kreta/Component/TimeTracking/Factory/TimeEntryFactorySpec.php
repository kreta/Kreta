<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\TimeTracking\Factory;

use PhpSpec\ObjectBehavior;

class TimeEntryFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\TimeTracking\Model\TimeEntry');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\TimeTracking\Factory\TimeEntryFactory');
    }

    function it_creates_time_entry()
    {
        $this->create()
            ->shouldReturnAnInstanceOf('Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface');
    }
} 
