<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    function newParticipantAction($id)
    {
        /** @var \Kreta\Component\Core\Model\Interfaces\UserInterface $user */
        $user = $this->get('kreta_core.repository_user')->findOneBy(array('email' => $this->getRequest()->get('email')));
        /** @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project */
        $project = $this->get('kreta_core.repository_project')->find($id);

        if(!$user) {
            throw $this->createNotFoundException('User not found');
        }

        if(!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        $project->addParticipant($user);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($project);
        $manager->flush();

        return $this->redirect($this->generateUrl('kreta_web_project_view', array('id' => $project->getId())));
    }
}
