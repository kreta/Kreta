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
 * Class CommentSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class CommentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Comment');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_comment_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\CommentInterface');
    }

    function its_created_at_is_datetime()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a dummy description of comment')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is a dummy description of comment');
    }

    function its_issue_is_mutable(IssueInterface $issue)
    {
        $this->setIssue($issue)->shouldReturn($this);
        $this->getIssue()->shouldReturn($issue);
    }

    function it_updated_at_is_mutable()
    {
        $updateDate = new \DateTime();

        $this->setUpdatedAt($updateDate)->shouldReturn($this);
        $this->getUpdatedAt()->shouldReturn($updateDate);
    }

    function its_written_by_is_mutable(UserInterface $user)
    {
        $this->setWrittenBy($user)->shouldReturn($this);
        $this->getWrittenBy()->shouldReturn($user);
    }
}
