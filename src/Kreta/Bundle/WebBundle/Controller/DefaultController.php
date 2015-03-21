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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DefaultController.
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->dashboardAction();
        }

        return $this->render('KretaWebBundle::layout.html.twig');
    }

    /**
     * Dashboard action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('KretaWebBundle::layout.html.twig');
    }
}
