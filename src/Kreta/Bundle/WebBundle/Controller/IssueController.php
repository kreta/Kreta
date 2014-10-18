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
use Kreta\Bundle\WebBundle\Form\Type\CommentType;
use Kreta\Bundle\WebBundle\Form\Type\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends Controller
{
    public function viewAction($id)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($id);
        if (!$issue) {
            $this->createNotFoundException();
        }

        return $this->render('KretaWebBundle:Issue:view.html.twig', array('issue' => $issue));
    }

    public function newAction(Request $request)
    {
        $issue = $this->get('kreta_core.factory_issue')->create();
        $issue->setReporter($this->getUser());

        $form = $this->createForm(new IssueType(), $issue);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($issue);
                $manager->flush();
                return $this->redirect($this->generateUrl('kreta_web_issue_view', array('id' => $issue->getId())));
            }
        }

        return $this->render('KretaWebBundle:Issue:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($id);
        if (!$issue) {
            $this->createNotFoundException();
        }

        $form = $this->createForm(new IssueType(), $issue);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($issue);
                $manager->flush();
                return $this->redirect($this->generateUrl('kreta_web_issue_view', array('id' => $issue->getId())));
            }
        }

        return $this->render('KretaWebBundle:Issue:edit.html.twig', array(
            'form' => $form->createView(),
            'issue' => $issue
        ));
    }

    function newCommentAction($issueId, Request $request)
    {
        $issue = $this->get('kreta_core.repository_issue')->find($issueId);
        if (!$issue) {
            $this->createNotFoundException('Issue not found');
        }
        $comment = $this->get('kreta_core.factory_comment')->create();

        $form = $this->createForm(new CommentType(), $comment);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $comment->setWrittenBy($this->getUser());
                $comment->setIssue($issue);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($comment);
                $manager->flush();
                return $this->redirect($this->generateUrl('kreta_web_issue_view', array('id' => $issue->getId())));
            }
            return $this->redirect($this->generateUrl('kreta_web_issue_view', array('id' => $issue->getId())));
        }

        return $this->render('KretaWebBundle:Issue/blocks:commentForm.html.twig', array('form' => $form->createView(), 'issue' => $issue));

    }
}
