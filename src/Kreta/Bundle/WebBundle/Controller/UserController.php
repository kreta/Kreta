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

use Kreta\Bundle\WebBundle\Form\Type\UserType;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class UserController.
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (($user instanceof UserInterface) === false) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod('POST') === true) {
            $form->handleRequest($request);
            if ($form->isSubmitted() === true && $form->isValid() === true) {
                $photo = $request->files->get('kreta_core_user_type')['photo'];
                if ($photo instanceof UploadedFile) {
                    $media = $this->get('kreta_core.factory_media')->create($photo);
                    $this->get('kreta_core.image_users_uploader')->upload($media);
                    $user->setPhoto($media);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->get('session')->getFlashBag()->add('success', 'Profile updated successfully');
            }
        }

        return $this->render('@KretaWeb/User/edit.html.twig', array('form' => $form->createView(), 'user' => $user));
    }
}
