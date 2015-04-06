<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Comment\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class CommentFactorySpec.
 *
 * @package spec\Kreta\Component\Comment\Factory
 */
class CommentFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Comment\Model\Comment');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Comment\Factory\CommentFactory');
    }

    function it_creates_a_project(IssueInterface $issue, UserInterface $user)
    {
        $this->create($issue, $user)->shouldReturnAnInstanceOf('Kreta\Component\Comment\Model\Comment');
    }
}
