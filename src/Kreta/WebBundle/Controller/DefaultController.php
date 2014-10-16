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

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ($this->getUser()) {
            return $this->dashboardAction();
        }
        return $this->render('KretaWebBundle:Default:index.html.twig');
    }

    public function dashboardAction()
    {
        return $this->render('KretaWebBundle:Default:dashboard.html.twig');
    }
}
