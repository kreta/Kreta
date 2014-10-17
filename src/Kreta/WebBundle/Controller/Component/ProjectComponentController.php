<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\WebBundle\Controller\Component;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectComponentController extends Controller
{
    public function userAction()
    {
        $projects = $this->get('kreta_core.repository_project')->findByParticipant($this->getUser());

        return $this->render('KretaWebBundle:Component/Project:user.html.twig', array('projects' => $projects));
    }
}
