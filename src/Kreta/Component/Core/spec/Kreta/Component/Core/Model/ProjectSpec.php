<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Model;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class ProjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Project');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_project_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\ProjectInterface');
    }

    function its_issues_is_collection()
    {
        $this->getIssues()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_participants_is_collection()
    {
        $this->getParticipants()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_issues_are_be_mutable(IssueInterface $issue)
    {
        $this->getIssues()->shouldHaveCount(0);

        $this->addIssue($issue);

        $this->getIssues()->shouldHaveCount(1);

        $this->removeIssue($issue);

        $this->getIssues()->shouldHaveCount(0);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name that it is a test for the PHPSpec');

        $this->getShortName()->shouldReturn('Dummy name that it is a te...');
    }

    function its_participants_are_be_mutable(UserInterface $participant)
    {
        $this->getParticipants()->shouldHaveCount(0);

        $this->addParticipant($participant);

        $this->getParticipants()->shouldHaveCount(1);

        $this->removeParticipant($participant);

        $this->getParticipants()->shouldHaveCount(0);
    }

    function its_short_name_is_mutable()
    {
        $this->setShortName('Dummy short name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name that it i...');

        $this->setShortName('Dummy short name')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name');
    }
}
