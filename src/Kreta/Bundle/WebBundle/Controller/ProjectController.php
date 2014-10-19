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

use Kreta\Bundle\WebBundle\Form\Type\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    function viewAction($id)
    {
        $project = $this->get('kreta_core.repository_project')->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        return $this->render('KretaWebBundle:Project:view.html.twig', array('project' => $project));
    }

    public function newAction(Request $request)
    {
        $project = $this->get('kreta_core.factory_project')->create();

        $form = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $participant = $this->get('kreta_core.factory_participant')->create($project, $this->getUser());
                $participant->setRole('ROLE_ADMIN');
                $project->addParticipant($participant);
                $manager->persist($participant);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Project created successfully');
                return $this->redirect($this->generateUrl('kreta_web_project_view', array('id' => $project->getId())));
            }
        }

        return $this->render('KretaWebBundle:Project:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $project = $this->get('kreta_core.repository_project')->find($id);

        if(!$project) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Project updated successfully');
                return $this->redirect($this->generateUrl('kreta_web_project_view', array('id' => $project->getId())));
            }
        }

        return $this->render('KretaWebBundle:Project:edit.html.twig', array(
            'form' => $form->createView(),
            'project' => $project,
        ));
    }

    public function newParticipantAction($id)
    {
        /** @var \Kreta\Component\Core\Model\Interfaces\UserInterface $user */
        $user = $this->get('kreta_core.repository_user')->findOneBy(array('email' => $this->getRequest()->get('email')));
        /** @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project */
        $project = $this->get('kreta_core.repository_project')->find($id);

        if(!$user) {
            $this->get('session')->getFlashBag()->add('error', 'User not found');
        } elseif(!$project) {
            throw $this->createNotFoundException('Project not found');
        } else {
            $participant = $this->get('kreta_core.factory_participant')->create($project, $user);
            $participant->setRole('ROLE_ADMIN');
            $project->addParticipant($participant);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($participant);
            $manager->flush();
            $this->get('session')->getFlashBag()->add('success', 'Participant added successfully');
        }

        return $this->redirect($this->generateUrl('kreta_web_project_view', array('id' => $project->getId())));
    }
}
