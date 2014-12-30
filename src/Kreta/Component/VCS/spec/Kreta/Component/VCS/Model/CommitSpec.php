<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Model;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use PhpSpec\ObjectBehavior;

class CommitSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Model\Commit');
    }

    function its_id_is_mutable()
    {
        $this->setId('1122')->shouldReturn($this);
        $this->getId()->shouldReturn('1122');
    }

    function its_author_is_mutable()
    {
        $this->setAuthor('gorkalaucirica')->shouldReturn($this);
        $this->getAuthor()->shouldReturn('gorkalaucirica');
    }

    function its_branch_is_mutable(BranchInterface $branch)
    {
        $this->setBranch($branch)->shouldReturn($this);
        $this->getBranch()->shouldReturn($branch);
    }

    function its_issues_related_is_mutable()
    {
        $this->setIssuesRelated([])->shouldReturn($this);
        $this->getIssuesRelated()->shouldReturn([]);
    }

    function its_message_is_mutable()
    {
        $this->setMessage('Test message')->shouldReturn($this);
        $this->getMessage()->shouldReturn('Test message');
    }

    function its_sha_is_mutable()
    {
        $this->setSha('1231412423423e2342')->shouldReturn($this);
        $this->getSha()->shouldReturn('1231412423423e2342');
    }

    function its_url_is_mutable()
    {
        $this->setUrl('http://github.com/kreta-io/kreta')->shouldReturn($this);
        $this->getUrl()->shouldReturn('http://github.com/kreta-io/kreta');
    }
} 
