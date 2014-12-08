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

use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     *
     * @Template
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException();
        }

        $form = $this->get('kreta_web.form_handler.user')->handleForm($request, $user);

        return ['form' => $form->createView(), 'user' => $user];
    }
}
