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
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProjectController.
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class ProjectController extends Controller
{
    /**
     * View action.
     *
     * @param string $projectShortName The project short name
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($projectShortName)
    {
        $project = $this->get('kreta_core.repository_project')->findOneBy(['shortName' => $projectShortName]);

        if (!$this->get('security.context')->isGranted('view', $project)) {
            throw new AccessDeniedException();
        };

        if (!$project instanceof ProjectInterface) {
            throw $this->createNotFoundException('Project not found');
        }

        return $this->render('KretaWebBundle:Project:view.html.twig', ['project' => $project]);
    }

    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $project = $this->get('kreta_core.factory_project')->create();

        $form = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $image = $request->files->get('kreta_core_project_type')['image'];
                if ($image instanceof UploadedFile) {
                    $media = $this->get('kreta_core.factory_media')->create($image);
                    $this->get('kreta_core.image_projects_uploader')->upload($media);
                    $project->setImage($media);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $participant = $this->get('kreta_core.factory_participant')->create($project, $this->getUser());
                $participant->setRole('ROLE_ADMIN');
                $project->addParticipant($participant);
                $manager->persist($participant);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Project created successfully');

                return $this->redirect($this->generateUrl('kreta_web_project_view', [
                    'projectShortName' => $project->getShortName()
                ]));
            }
        }

        return $this->render('KretaWebBundle:Project:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     * @param string                                    $projectShortName The project short name
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $projectShortName)
    {
        $project = $this->get('kreta_core.repository_project')->findOneBy(['shortName' => $projectShortName]);

        if (!$project instanceof ProjectInterface) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('security.context')->isGranted('edit', $project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $image = $request->files->get('kreta_core_project_type')['image'];
                if ($image instanceof UploadedFile) {
                    $media = $this->get('kreta_core.factory_media')->create($image);
                    $this->get('kreta_core.image_projects_uploader')->upload($media);
                    $project->setImage($media);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Project updated successfully');

                return $this->redirect($this->generateUrl('kreta_web_project_view', [
                    'projectShortName' => $project->getShortName()
                ]));
            }
        }

        return $this->render('KretaWebBundle:Project:edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project
        ]);
    }

    /**
     * New participant action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request          The request
     * @param string                                    $projectShortName The project short name
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newParticipantAction(Request $request, $projectShortName)
    {
        $user = $this->get('kreta_core.repository_user')->findOneBy(['email' => $request->get('email')]);
        $project = $this->get('kreta_core.repository_project')->findOneBy(['shortName' => $projectShortName]);

        if (!$this->get('security.context')->isGranted('add_participant', $project)) {
            throw new AccessDeniedException();
        }

        if (!$user instanceof UserInterface) {
            $this->get('session')->getFlashBag()->add('error', 'User not found');
        } elseif (!$project instanceof ProjectInterface) {
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

        return $this->redirect($this->generateUrl('kreta_web_project_view', [
            'projectShortName' => $project->getShortName()
        ]));
    }
}
