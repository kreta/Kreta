<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CommentBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CommentBundle\Form\Handler\Api\CommentHandler;
use Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller\BaseRestController;
use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Comment\Repository\CommentRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommentControllerSpec.
 *
 * @package spec\Kreta\Bundle\CommentBundle\Controller
 */
class CommentControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CommentBundle\Controller\CommentController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_does_not_get_comments_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        CommentRepository $commentRepository,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher
    )
    {
        $container->get('kreta_comment.repository.comment')->shouldBeCalled()->willReturn($commentRepository);
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getCommentsAction', ['issue-id', $paramFetcher]);
    }

    function it_gets_comments(
        ContainerInterface $container,
        CommentRepository $commentRepository,
        IssueRepository $issueRepository,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher,
        IssueInterface $issue,
        CommentInterface $comment
    )
    {
        $container->get('kreta_comment.repository.comment')->shouldBeCalled()->willReturn($commentRepository);
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext);
        $paramFetcher->get('createdAt')->shouldBeCalled()->willReturn('2014-10-20');
        $paramFetcher->get('owner')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);

        $commentRepository->findByIssue($issue, new \DateTime('2014-10-20'), 'user@kreta.com', 10, 1)
            ->shouldBeCalled()->willReturn([$comment]);

        $this->getCommentsAction('issue-id', $paramFetcher)->shouldReturn([$comment]);
    }

    function it_does_not_post_comments_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('postCommentsAction', ['issue-id']);
    }

    function it_posts_comment(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        CommentHandler $commentHandler,
        Request $request,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        CommentInterface $comment
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext);
        $container->get('kreta_comment.form_handler.api.comment')->shouldBeCalled()->willReturn($commentHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $commentHandler->processForm($request, null, ['issue' => $issue])->shouldBeCalled()->willReturn($comment);

        $this->postCommentsAction('issue-id')->shouldReturn($comment);
    }

    function it_does_not_put_comment_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('putCommentsAction', ['issue-id', 'comment-id']);
    }

    function it_puts_comment(
        ContainerInterface $container,
        CommentRepository $commentRepository,
        CommentHandler $commentHandler,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        CommentInterface $comment,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        Request $request
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext);
        $container->get('kreta_comment.repository.comment')->shouldBeCalled()->willReturn($commentRepository);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $commentRepository->findOneBy(['id' => 'comment-id', 'writtenBy' => $user], false)
            ->shouldBeCalled()->willReturn($comment);

        $container->get('kreta_comment.form_handler.api.comment')->shouldBeCalled()->willReturn($commentHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $comment->getIssue()->shouldBeCalled()->willReturn($issue);
        $commentHandler->processForm($request, $comment, ['method' => 'PUT', 'issue' => $issue])
            ->shouldBeCalled()->willReturn($comment);

        $this->putCommentsAction('issue-id', 'comment-id')->shouldReturn($comment);
    }
}
