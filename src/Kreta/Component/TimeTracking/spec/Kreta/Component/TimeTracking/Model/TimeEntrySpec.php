<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\TimeTracking\Model;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class TimeEntrySpec.
 *
 * @package spec\Kreta\Component\TimeTracking\Model
 */
class TimeEntrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\TimeTracking\Model\TimeEntry');
    }

    function it_implements_time_tracking_interface()
    {
        $this->shouldImplement('Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface');
    }

    function it_should_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_date_reported_is_mutable(\DateTime $dateReported)
    {
        $this->setDateReported($dateReported)->shouldReturn($this);
        $this->getDateReported()->shouldReturn($dateReported);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('Description')->shouldReturn($this);
        $this->getDescription()->shouldReturn('Description');
    }

    function its_issue_is_mutable(IssueInterface $issue)
    {
        $this->setIssue($issue)->shouldReturn($this);
        $this->getIssue()->shouldReturn($issue);
    }

    function its_time_spent_is_mutable()
    {
        $this->setTimeSpent(60 * 60)->shouldReturn($this);
        $this->getTimeSpent()->shouldReturn(60 * 60);
    }
}
