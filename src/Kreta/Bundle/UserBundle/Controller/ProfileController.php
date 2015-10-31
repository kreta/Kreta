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

namespace Kreta\Bundle\UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\View;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * Returns the info of user logged.
     *
     * @ApiDoc(statusCodes={200})
     * @View(statusCode=200, serializerGroups={"profile"})
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function getProfileAction()
    {
        return $this->getUser();
    }

    /**
     * Updates the info of user logged.
     *
     * This method should be PUT request, but it's POST to solve a
     * PHP limitation with the multipart/form-data behaviour.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @ApiDoc(statusCodes={200, 400})
     * @Http\Post("/profile")
     * @View(statusCode=200, serializerGroups={"profile"})
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function postProfileAction(Request $request)
    {
        return $this->get('kreta_user.form_handler.profile')->processForm($request);
    }
}
