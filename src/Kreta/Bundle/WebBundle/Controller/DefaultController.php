<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\WebBundle\Controller;

use Kreta\Bundle\UserBundle\Event\CookieEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Default controller class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser() instanceof UserInterface) {
//            $event = $this->get('event_dispatcher')->dispatch(
//                CookieEvent::NAME, new CookieEvent($request->getSession())
//            );
//
//            return $this->dashboardAction();
            return $this->render('KretaWebBundle::app.html.twig');
        }
//
        return $this->render('KretaWebBundle::index.html.twig');
//
//        return $this->render('KretaWebBundle::app.html.twig');
    }

//    /**
//     * Dashboard action.
//     *
//     * @param \Symfony\Component\HttpFoundation\Response $response The response
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function dashboardAction(Response $response)
//    {
//        return $this->render('KretaWebBundle::app.html.twig', [], $response);
//    }
}
