<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Event;

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NewCommitEventSpec.
 *
 * @package spec\Kreta\Component\VCS\Event
 */
class NewCommitEventSpec extends ObjectBehavior
{
    function let(CommitInterface $commit)
    {
        $this->beConstructedWith($commit);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Event\NewCommitEvent');
    }

    function it_extends_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_gets_commit(CommitInterface $commit)
    {
        $this->getCommit()->shouldReturn($commit);
    }
}
