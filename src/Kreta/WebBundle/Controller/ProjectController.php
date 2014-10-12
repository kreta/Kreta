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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    function viewAction($id)
    {
        $project = $this->get('kreta_core.repository_project')->find($id);

        if (!$project) {
            throw new NotFoundHttpException();
        }

        return $this->render('KretaWebBundle:Project:view.html.twig', array('project' => $project));
    }
}
