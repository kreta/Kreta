<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CommentBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommentHandlerSpec.
 *
 * @package spec\Kreta\Bundle\CommentBundle\Form\Handler
 */
class CommentHandlerSpec extends ObjectBehavior
{
    function let(FormFactory $formFactory, ObjectManager $manager, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Handler\CommentHandler');
    }

    function it_extends_abstract_form_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_handles_form(Request $request, CommentInterface $comment, FormFactory $formFactory)
    {
        $formFactory->create(Argument::type('Kreta\Bundle\CommentBundle\Form\Type\CommentType'), $comment, []);

        $this->handleForm($request, $comment, []);
    }
}
