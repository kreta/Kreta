<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\TimeTracking\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class TimeEntryFactorySpec
 *
 * @package spec\Kreta\Component\TimeTracking\Factory
 */
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

    function it_creates_time_entry(IssueInterface $issue)
    {
        $this->create($issue)
            ->shouldReturnAnInstanceOf('Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface');
    }
}
