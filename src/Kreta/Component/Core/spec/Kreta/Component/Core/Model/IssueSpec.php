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

use Kreta\Component\Core\Model\Interfaces\CommentInterface;
use Kreta\Component\Core\Model\Interfaces\LabelInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ResolutionInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class IssueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Issue');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_issue_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\IssueInterface');
    }

    function its_assigners_comments_labels_and_watchers_is_collection()
    {
        $this->getComments()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getLabels()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getWatchers()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_assignee_be_mutable(UserInterface $assignee)
    {
        $this->setAssignee($assignee)->shouldReturn($this);
        $this->getAssignee()->shouldReturn($assignee);
    }

    function its_comments_be_mutable(CommentInterface $comment)
    {
        $this->getComments()->shouldHaveCount(0);

        $this->addComment($comment);

        $this->getComments()->shouldHaveCount(1);

        $this->removeComment($comment);

        $this->getComments()->shouldHaveCount(0);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a dummy description of issue')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is a dummy description of issue');
    }

    function its_labels_be_mutable(LabelInterface $label)
    {
        $this->getLabels()->shouldHaveCount(0);

        $this->addLabel($label);

        $this->getlabels()->shouldHaveCount(1);

        $this->removeLabel($label);

        $this->getLabels()->shouldHaveCount(0);
    }

    function its_priority_is_mutable()
    {
        $this->setPriority(0)->shouldReturn($this);
        $this->getPriority()->shouldReturn(0);
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }

    function its_resolution_is_mutable(ResolutionInterface $resolution)
    {
        $this->setResolution($resolution)->shouldReturn($this);
        $this->getResolution()->shouldReturn($resolution);
    }

    function its_reporter_is_mutable(UserInterface $reporter)
    {
        $this->setReporter($reporter)->shouldReturn($this);
        $this->getReporter()->shouldReturn($reporter);
    }

    function its_status_is_mutable(StatusInterface $status)
    {
        $this->setStatus($status)->shouldReturn($this);
        $this->getStatus()->shouldReturn($status);
    }

    function its_title_is_mutable()
    {
        $this->setTitle('Dummy title')->shouldReturn($this);
        $this->getTitle()->shouldReturn('Dummy title');
    }

    function its_type_is_mutable()
    {
        $this->setType(0)->shouldReturn($this);
        $this->getType()->shouldReturn(0);
    }

    function its_watchers_be_mutable(UserInterface $watcher)
    {
        $this->getWatchers()->shouldHaveCount(0);

        $this->addWatcher($watcher);

        $this->getWatchers()->shouldHaveCount(1);

        $this->removeWatcher($watcher);

        $this->getLabels()->shouldHaveCount(0);
    }
}
