<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Controller\Component;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProjectComponentController.
 *
 * @package Kreta\Bundle\WebBundle\Controller\Component
 */
class ProjectComponentController extends Controller
{
    /**
     * User action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction()
    {
        $projects = $this->get('kreta_core.repository.project')->findByParticipant($this->getUser());

        return $this->render('KretaWebBundle:Component/Project:user.html.twig', ['projects' => $projects]);
    }
}
