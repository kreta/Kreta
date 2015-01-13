<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\Controller;

use Kreta\Bundle\CommentBundle\Form\Handler\CommentHandler;
use Kreta\Component\Comment\Factory\CommentFactory;
use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Comment\Repository\CommentRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentControllerSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\Controller
 */
class CommentControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\CommentController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_lists_issue(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        IssueRepository $repository,
        CommentRepository $commentRepository,
        IssueInterface $issue,
        CommentInterface $comment
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->find('issue-id', false)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_comment.repository.comment')->shouldBeCalled()->willReturn($commentRepository);
        $commentRepository->findBy(['issue' => $issue], ['createdAt' => 'DESC'])
            ->shouldBeCalled()->willReturn([$comment]);

        $this->listAction('issue-id')->shouldReturn(['comments' => [$comment], 'issue' => $issue]);
    }

    function it_does_not_list_comments_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $repository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->find('issue-id', false)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException())->during('listAction', ['issue-id']);
    }

    function it_does_not_add_comment_because_the_form_is_not_valid(
        ContainerInterface $container,
        Request $request,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        IssueRepository $repository,
        IssueInterface $issue,
        CommentFactory $commentFactory,
        CommentInterface $comment,
        CommentHandler $commentHandler,
        FormInterface $form,
        FormView $view
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($repository);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $repository->findOneByShortCode('KRT', 65)->shouldBeCalled()->willReturn($issue);
        $container->get('kreta_comment.factory.comment')->shouldBeCalled()->willReturn($commentFactory);
        $commentFactory->create($issue, $user)->shouldBeCalled()->willReturn($comment);
        $container->get('kreta_comment.form_handler.comment')->shouldBeCalled()->willReturn($commentHandler);
        $commentHandler->handleForm($request, $comment)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->createView()->shouldBeCalled()->willReturn($view);

        $this->newCommentAction('KRT', 65, $request)->shouldReturn(['form' => $view, 'issue' => $issue]);
    }

    function it_adds_comment(
        ContainerInterface $container,
        Request $request,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        IssueRepository $repository,
        IssueInterface $issue,
        CommentFactory $commentFactory,
        CommentInterface $comment,
        CommentHandler $commentHandler,
        FormInterface $form,
        ProjectInterface $project,
        Router $router
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($repository);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $repository->findOneByShortCode('KRT', 65)->shouldBeCalled()->willReturn($issue);
        $container->get('kreta_comment.factory.comment')->shouldBeCalled()->willReturn($commentFactory);
        $commentFactory->create($issue, $user)->shouldBeCalled()->willReturn($comment);
        $container->get('kreta_comment.form_handler.comment')->shouldBeCalled()->willReturn($commentHandler);
        $commentHandler->handleForm($request, $comment)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getShortName()->shouldBeCalled()->willReturn('KRT');
        $issue->getNumericId()->shouldBeCalled()->willReturn(1);
        $container->get('router')->shouldBeCalled()->willReturn($router);
        $router->generate('kreta_web_issue_view', ['projectShortName' => 'KRT', 'issueNumber' => 1], false)
            ->shouldBeCalled()->willReturn('url-generate');

        $this->newCommentAction('KRT', 65, $request)
            ->shouldReturnAnInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse');
    }
}
