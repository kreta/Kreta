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

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class UserController extends Controller
{
    /**
     * Returns all the users, it admits filters, sort, limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(email|username|createdAt)", default="username", description="Sort")
     * @QueryParam(name="email", requirements="(.*)", strict=true, nullable=true, description="Email filter")
     * @QueryParam(name="username", requirements="(.*)", strict=true, nullable=true, description="Username filter")
     * @QueryParam(name="firstName", requirements="(.*)", strict=true, nullable=true, description="First name filter")
     * @QueryParam(name="lastName", requirements="(.*)", strict=true, nullable=true, description="Last name filter")
     * @QueryParam(name="enabled", requirements="(.*)", strict=true, nullable=true, description="Enabled filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of users to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200})
     * @View(statusCode=200, serializerGroups={"userList"})
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface[]
     */
    public function getUsersAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_user.repository.user')->findBy(
            [
                'like' => [
                        'email'     => $paramFetcher->get('email'),
                        'username'  => $paramFetcher->get('username'),
                        'firstName' => $paramFetcher->get('firstName'),
                        'lastName'  => $paramFetcher->get('lastName'),
                        'enabled'   => $paramFetcher->get('enabled'),
                    ],
            ],
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }
}
