<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Model;

use Kreta\CoreBundle\Model\Interfaces\CommentInterface;
use Kreta\CoreBundle\Model\Interfaces\LabelInterface;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueSpec.
 *
 * @package spec\Kreta\CoreBundle\Model
 */
class IssueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Issue');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Abstracts\AbstractModel');
    }

    function it_implements_issue_interface()
    {
        $this->shouldImplement('Kreta\CoreBundle\Model\Interfaces\IssueInterface');
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

    function its_resolution_is_mutable()
    {
        $this->setResolution(0)->shouldReturn($this);
        $this->getResolution()->shouldReturn(0);
    }

    function its_reporter_is_mutable(UserInterface $reporter)
    {
        $this->setReporter($reporter)->shouldReturn($this);
        $this->getReporter()->shouldReturn($reporter);
    }

    function its_status_is_mutable()
    {
        $this->setStatus(0)->shouldReturn($this);
        $this->getStatus()->shouldReturn(0);
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
