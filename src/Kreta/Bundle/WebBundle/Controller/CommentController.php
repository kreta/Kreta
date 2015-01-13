<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Controller;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CommentController.
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class CommentController extends Controller
{
    /**
     * List action.
     *
     * @param string $issueId The issue id
     *
     * @return array
     *
     * @Template("KretaWebBundle:Comment:list.html.twig")
     */
    public function listAction($issueId)
    {
        $issue = $this->get('kreta_issue.repository.issue')->find($issueId, false);
        if (!$this->get('security.context')->isGranted('view', $issue)) {
            throw new AccessDeniedException();
        };

        $comments = $this->get('kreta_comment.repository.comment')->findBy(
            ['issue' => $issue], ['createdAt' => 'DESC']
        );

        return ['comments' => $comments, 'issue' => $issue];
    }

    /**
     * New comment action.
     *
     * @param string                                    $projectShortName Project short name
     * @param string                                    $issueNumber      The issue number
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     *
     * @Template("KretaWebBundle:Issue/blocks:commentForm.html.twig")
     */
    public function newCommentAction($projectShortName, $issueNumber, Request $request)
    {
        $issue = $this->get('kreta_issue.repository.issue')->findOneByShortCode($projectShortName, $issueNumber);
        if (!$issue instanceof IssueInterface) {
            $this->createNotFoundException('Issue not found');
        }

        $comment = $this->get('kreta_comment.factory.comment')->create($issue, $this->getUser());

        $form = $this->get('kreta_comment.form_handler.comment')->handleForm($request, $comment);
        if ($form->isValid()) {
            return $this->redirect($this->generateUrl(
                'kreta_web_issue_view', [
                    'projectShortName' => $issue->getProject()->getShortName(),
                    'issueNumber'      => $issue->getNumericId()
                ]
            ));
        }

        return ['form' => $form->createView(), 'issue' => $issue];
    }
}
