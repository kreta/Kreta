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

use FOS\RestBundle\Controller\Annotations\View;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController.
 *
 * @package Kreta\Bundle\UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Returns all the users.
     *
     * @ApiDoc(resource=true, statusCodes={200})
     * @View(statusCode=200, serializerGroups={"userList"})
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface[]
     */
    public function getUsersAction()
    {
        return $this->get('kreta_user.repository.user')->findAll();
    }
}
