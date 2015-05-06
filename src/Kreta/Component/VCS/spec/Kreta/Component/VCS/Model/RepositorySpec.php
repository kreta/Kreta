<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Model;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class RepositorySpec.
 *
 * @package spec\Kreta\Component\VCS\Model
 */
class RepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Model\Repository');
    }

    function it_implements_reository_interface()
    {
        $this->shouldImplement('Kreta\Component\VCS\Model\Interfaces\RepositoryInterface');
    }

    function it_does_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('kreta_io/kreta')->shouldReturn($this);
        $this->getName()->shouldReturn('kreta_io/kreta');
    }

    function its_project_are_mutable(ProjectInterface $project)
    {
        $this->addProject($project)->shouldReturn($this);

        $this->getProjects()->shouldHaveCount(1);

        $this->removeProject($project)->shouldReturn($this);

        $this->getProjects()->shouldHaveCount(0);
    }

    function its_provider_is_mutable()
    {
        $this->setProvider('github')->shouldReturn($this);
        $this->getProvider()->shouldReturn('github');
    }

    function its_url_is_mutable()
    {
        $this->setUrl('https://github.com/kreta-io/kreta')->shouldReturn($this);
        $this->getUrl()->shouldReturn('https://github.com/kreta-io/kreta');
    }
}
