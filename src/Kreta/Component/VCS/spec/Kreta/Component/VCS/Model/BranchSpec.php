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

use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BranchSpec.
 *
 * @package spec\Kreta\Component\VCS\Model
 */
class BranchSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Model\Branch');
    }

    function it_implements_branch_interface()
    {
        $this->shouldImplement('Kreta\Component\VCS\Model\Interfaces\BranchInterface');
    }

    function its_id_is_mutable()
    {
        $this->setId('1111')->shouldReturn($this);
        $this->getId()->shouldReturn('1111');
    }

    function its_name_is_mutable()
    {
        $this->setName('master')->shouldReturn($this);
        $this->getName()->shouldReturn('master');
    }

    function its_repository_is_mutable(RepositoryInterface $repository)
    {
        $this->setRepository($repository)->shouldReturn($this);
        $this->getRepository()->shouldReturn($repository);
    }

    function its_issues_related_is_mutable()
    {
        $this->setIssuesRelated([])->shouldReturn($this);
        $this->getIssuesRelated()->shouldReturn([]);
    }

    function it_generates_url_for_github(RepositoryInterface $repository)
    {
        $repository->getProvider()->shouldBeCalled()->willReturn('github');
        $repository->getName()->shouldBeCalled()->willReturn('kreta-io/kreta');
        $this->setRepository($repository);
        $this->setName('KRT-42-test-url-generation');

        $this->getUrl()->shouldReturn('https://github.com/kreta-io/kreta/tree/KRT-42-test-url-generation');
    }

    function it_generates_default_url(RepositoryInterface $repository)
    {
        $repository->getProvider()->shouldBeCalled()->willReturn('default-provider');
        $this->setRepository($repository);
        $this->setName('KRT-42-test-url-generation');

        $this->getUrl()->shouldReturn('');
    }
}
