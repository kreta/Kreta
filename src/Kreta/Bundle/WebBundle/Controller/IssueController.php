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

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class IssueController.
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class IssueController extends Controller
{
    /**
     * View action.
     *
     * @param string $projectShortName Project shortname
     * @param string $issueNumber      The issue number
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($projectShortName, $issueNumber)
    {
        $issue = $this->get('kreta_core.repository_issue')->findOneByShortCode($projectShortName, $issueNumber);

        if (!$issue instanceof IssueInterface) {
            $this->createNotFoundException();
        }

        if (!$this->get('security.context')->isGranted('view', $issue)) {
            throw new AccessDeniedException();
        };

        return $this->render('KretaWebBundle:Issue:view.html.twig', [
            'issue' => $issue
        ]);
    }

    /**
     * New action.
     *
     * @param string                                    $projectShortName Project shortname
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction($projectShortName, Request $request)
    {
        /** @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project */
        $project = $this->get('kreta_core.repository_project')->findOneBy([
            'shortName' => $projectShortName
        ]);

        if (!$project || !$this->get('security.context')->isGranted('create_issue', $project)) {
            throw new AccessDeniedException();
        }

        $issue = $this->get('kreta_core.factory_issue')->create($project, $this->getUser());

        $form = $this->get('kreta_web.form_handler_issue')->handleForm(
            $request, $issue, $project->getParticipants()
        );

        if ($form->isValid()) {
            return $this->redirect($this->generateUrl(
                'kreta_web_issue_view', [
                    'projectShortName' => $issue->getProject()->getShortName(),
                    'issueNumber' => $issue->getNumericId()
                ]));
        }

        return $this->render('KretaWebBundle:Issue:new.html.twig', [
            'form' => $form->createView(), 'project' => $project
        ]);
    }

    /**
     * Edit action.
     *
     * @param string                                    $projectShortName Project shortname
     * @param string                                    $issueNumber      The issue number
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($projectShortName, $issueNumber, Request $request)
    {
        $issue = $this->get('kreta_core.repository_issue')->findOneByShortCode($projectShortName, $issueNumber);

        if (!$issue instanceof IssueInterface) {
            $this->createNotFoundException();
        }

        if (!$this->get('security.context')->isGranted('edit', $issue)) {
            throw new AccessDeniedException();
        };

        $form = $this->get('kreta_web.form_handler_issue')->handleForm(
            $request, $issue, $issue->getProject()->getParticipants()
        );

        if ($form->isValid()) {
            return $this->redirect($this->generateUrl(
                'kreta_web_issue_view', [
                    'projectShortName' => $issue->getProject()->getShortName(),
                    'issueNumber' => $issue->getNumericId()
                ]
            ));
        }

        return $this->render('KretaWebBundle:Issue:edit.html.twig', ['form' => $form->createView(), 'issue' => $issue]);
    }

    /**
     * New comment action.
     *
     * @param string                                    $projectShortName Project shortname
     * @param string                                    $issueNumber      The issue number
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCommentAction($projectShortName, $issueNumber, Request $request)
    {
        $issue = $this->get('kreta_core.repository_issue')->findOneByShortCode($projectShortName, $issueNumber);

        if (!$issue instanceof IssueInterface) {
            $this->createNotFoundException('Issue not found');
        }

        $comment = $this->get('kreta_core.factory_comment')->create($issue, $this->getUser());

        $form = $this->get('kreta_web.form_handler_comment')->handleForm($request, $comment);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl(
                'kreta_web_issue_view', [
                    'projectShortName' => $issue->getProject()->getShortName(),
                    'issueNumber' => $issue->getNumericId()
                ]
            ));
        }

        return $this->render('KretaWebBundle:Issue/blocks:commentForm.html.twig', [
            'form' => $form->createView(),
            'issue' => $issue
        ]);
    }

    /**
     * Edit status action.
     *
     * @param string $projectShortName Project shortname
     * @param string $issueNumber      The issue number
     * @param string $transitionId     The transition id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editStatusAction($projectShortName, $issueNumber, $transitionId)
    {
        $issue = $this->get('kreta_core.repository_issue')->findOneByShortCode($projectShortName, $issueNumber);

        if (!$issue instanceof IssueInterface) {
            $this->createNotFoundException();
        }

        if (!$this->get('security.context')->isGranted('edit', $issue)) {
            throw new AccessDeniedException();
        };

        $transition = $this->get('kreta_core.repository_status_transition')->find($transitionId);

        if (!$transition instanceof StatusTransitionInterface ||
            $issue->getProject()->getId() !== $transition->getProject()->getId()
        ) {
            $this->createNotFoundException();
        }

        $statuses = $this->get('kreta_core.repository_status')->findByProject($issue->getProject());
        $transitions = $this->get('kreta_core.repository_status_transition')->findByProject($issue->getProject());

        $stateMachine = $this->get('kreta_issue_state_machine')->load($issue, $statuses, $transitions);

        if ($stateMachine->can($transition->getName())) {
            $stateMachine->apply($transition->getName());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Status changed successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Transition not allowed');
        }

        return $this->redirect($this->generateUrl(
            'kreta_web_issue_view', [
                'projectShortName' => $issue->getProject()->getShortName(),
                'issueNumber' => $issue->getNumericId()
            ]
        ));
    }
}
