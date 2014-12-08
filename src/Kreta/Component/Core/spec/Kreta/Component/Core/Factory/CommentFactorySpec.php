<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CommentFactorySpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class CommentFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Core\Model\Comment');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\CommentFactory');
    }

    function it_creates_a_project(IssueInterface $issue, UserInterface $user)
    {
        $this->create($issue, $user)->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\Comment');
    }
}
