<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CommentBundle\Form\Type\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CommentTypeSpec.
 *
 * @package spec\Kreta\Bundle\CommentBundle\Form\Type\Api
 */
class CommentTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Type\Api\CommentType');
    }

    function it_extends_comment_type()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Type\CommentType');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
