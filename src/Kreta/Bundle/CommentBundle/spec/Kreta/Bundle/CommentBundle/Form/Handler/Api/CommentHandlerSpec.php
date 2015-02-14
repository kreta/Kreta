<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CommentBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Comment\Factory\CommentFactory;
use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentHandlerSpec.
 *
 * @package spec\Kreta\Bundle\CommentBundle\Form\Handler\Api
 */
class CommentHandlerSpec extends ObjectBehavior
{
    function let(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        CommentFactory $factory
    )
    {
        $this->beConstructedWith($formFactory, $manager, $eventDispatcher, $context, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Form\Handler\Api\CommentHandler');
    }

    function it_extends_abstract_form_handler()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler');
    }

    function it_does_not_handle_form_because_issue_key_does_not_exist(CommentInterface $comment, Request $request)
    {
        $this->shouldThrow(new ParameterNotFoundException('issue'))
            ->during('handleForm', [$request, $comment, []]);
    }

    function it_handles_form(
        Request $request,
        CommentInterface $comment,
        FormFactory $formFactory,
        FormInterface $form,
        IssueInterface $issue
    )
    {
        $formFactory->create(Argument::type('\Kreta\Bundle\CommentBundle\Form\Type\Api\CommentType'), $comment, [])
            ->shouldBeCalled()->willReturn($form);

        $this->handleForm($request, $comment, ['issue' => $issue])->shouldReturn($form);
    }
}
