<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class InvitationController.
 *
 * @package Kreta\Bundle\UserBundle\Controller
 */
class InvitationController extends Controller
{
    /**
     * Creates the user. Registers the user into db with an email given and with a simple password,
     * then sends an invitation to the email given, for updating the user info.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @ApiDoc(statusCodes={201, 400}, parameters={{
     *     "name"="force", "dataType"="bool", "required"=false, "description"="Forces to send another invitation email"
     *   }}
     * )
     * @Http\Post("/users")
     * @View(statusCode=201, serializerGroups={"user"})
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function postUsersAction(Request $request)
    {
        $user = $this->get('kreta_user.repository.user')->findOneBy(['email' => $request->request->get('email')]);
        if (!$user instanceof UserInterface || (true == $request->request->get('force') && $user->isEnabled())) {
            $request->request->remove('force');
            $user = $this->get('kreta_user.form_handler.invitation')->processForm($request, $user);
        }
        $this->get('kreta_user.mailer')->sendInvitationEmail($user);

        return $user;
    }
}
