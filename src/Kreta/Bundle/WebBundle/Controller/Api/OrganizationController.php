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

namespace Kreta\Bundle\WebBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Organization private api controller class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationController extends Controller
{
    /**
     * Returns the organization for given slug.
     *
     * @param string $organizationSlug The slug of organization
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Rest\View(statusCode=200, serializerGroups={"organization, private_api"})
     * @Rest\Get("/organizations/{organizationSlug}", name="get_private_organizations", options={"method_prefix" = false})
     *
     * @return OrganizationInterface
     */
    public function getOrganizationAction($organizationSlug)
    {
        $organization = $this->get('kreta_organization.repository.organization')->findOneBy(
            ['slug' => $organizationSlug], false
        );

        return $organization;
    }
}
