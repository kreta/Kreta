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

use Kreta\Bundle\WebBundle\Form\Type\CommentType;
use Kreta\Bundle\WebBundle\Form\Type\IssueType;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
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
     * @param string $projectId The project id
     * @param string $issueId   The id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($projectId, $issueId)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($issueId);

        if (($issue instanceof IssueInterface) === false) {
            $this->createNotFoundException();
        }

        if ($this->get('security.context')->isGranted('view', $issue) === false) {
            throw new AccessDeniedException();
        };

        return $this->render('KretaWebBundle:Issue:view.html.twig', array('issue' => $issue));
    }

    /**
     * New action.
     *
     * @param integer                                   $projectId Id of the project
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction($projectId, Request $request)
    {
        /** @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project */
        $project = $this->get('kreta_core.repository_project')->find($projectId);

        if (!$project || $this->get('security.context')->isGranted('create_issue', $project)) {
            throw new AccessDeniedException();
        }

        $issue = $this->get('kreta_core.factory_issue')->create($project, $this->getUser());

        $form = $this->createForm(new IssueType($project->getParticipants()), $issue);

        if ($request->isMethod('POST') === true) {
            $form->handleRequest($request);
            if ($form->isSubmitted() === true && $form->isValid() === true) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($issue);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Issue created successfully');

                return $this->redirect($this->generateUrl(
                    'kreta_web_issue_view',
                    array('projectId' => $issue->getProject()->getId(), 'issueId' => $issue->getId())
                ));
            }
            $this->get('session')->getFlashBag()->add('error', 'Some errors found in your issue');
        }

        return $this->render('KretaWebBundle:Issue:new.html.twig',
            array('form' => $form->createView(), 'project' => $project));
    }

    /**
     * Edit action.
     *
     * @param string                                    $projectId The project id
     * @param string                                    $issueId   The id
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($projectId, $issueId, Request $request)
    {
        /** @var IssueInterface $issue */
        $issue = $this->get('kreta_core.repository_issue')->find($issueId);

        if (($issue instanceof IssueInterface) === false) {
            $this->createNotFoundException();
        }

        if ($this->get('security.context')->isGranted('edit', $issue) === false) {
            throw new AccessDeniedException();
        };

        $form = $this->createForm(new IssueType($issue->getProject()->getParticipants()), $issue);

        if ($request->isMethod('POST') === true) {
            $form->handleRequest($request);
            if ($form->isSubmitted() === true && $form->isValid() === true) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($issue);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Issue edited successfully');

                return $this->redirect($this->generateUrl(
                    'kreta_web_issue_view',
                    array('projectId' => $issue->getProject()->getId(), 'issueId' => $issue->getId())
                ));
            }
            $this->get('session')->getFlashBag()->add('error', 'Some errors found in your issue');
        }

        return $this->render('KretaWebBundle:Issue:edit.html.twig', array(
            'form' => $form->createView(),
            'issue' => $issue
        ));
    }

    /**
     * New comment action.
     *
     * @param string                                    $projectId The project id
     * @param string                                    $issueId   The issue id
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCommentAction($projectId, $issueId, Request $request)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($issueId);

        if (($issue instanceof IssueInterface) === false) {
            $this->createNotFoundException('Issue not found');
        }

        $comment = $this->get('kreta_core.factory_comment')->create();

        $form = $this->createForm(new CommentType(), $comment);

        if ($request->isMethod('POST') === true) {
            $form->handleRequest($request);
            if ($form->isSubmitted() === true && $form->isValid() === true) {
                $comment->setWrittenBy($this->getUser());
                $comment->setIssue($issue);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($comment);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Comment added successfully');
            }

            return $this->redirect($this->generateUrl(
                'kreta_web_issue_view',
                array('projectId' => $issue->getProject()->getId(), 'issueId' => $issue->getId())
            ));
        }

        return $this->render('KretaWebBundle:Issue/blocks:commentForm.html.twig', array(
            'form' => $form->createView(),
            'issue' => $issue
        ));
    }

    /**
     * Edit status action.
     *
     * @param string $issueId  The issue id
     * @param string $statusId The issue id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editStatusAction($issueId, $statusId)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($issueId);

        if (($issue instanceof IssueInterface) === false) {
            $this->createNotFoundException();
        }

        if ($this->get('security.context')->isGranted('edit', $issue) === false) {
            throw new AccessDeniedException();
        };

        $status = $this->get('kreta_core.repository_status')->find($statusId);

        if (($issue instanceof StatusInterface) === false) {
            $this->createNotFoundException();
        }

        $statuses = $this->get('kreta_core.repository_status')->findByProject($issue->getProject());

        $stateMachine = $this->get('kreta_issue_state_machine')->load($issue, $statuses);

        try {
            $stateMachine->apply($issue->getStatus()->getName() . '-' . $status->getName());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Status changed successfully');
        } catch (\Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Transition not allowed');
        }

        return $this->redirect($this->generateUrl('kreta_web_issue_view',
            array('projectId' => $issue->getProject()->getId(), 'issueId' => $issue->getId())));
    }
}
