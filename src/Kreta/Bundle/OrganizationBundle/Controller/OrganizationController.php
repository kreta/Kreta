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

namespace Kreta\Bundle\OrganizationBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Organization;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Organization controller class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationController extends Controller
{
    /**
     * Returns all the organizations of current user, it admits sort, limit and offset.
     *
     * @param ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of orgs to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200})
     * @View(statusCode=200, serializerGroups={"organizationList"})
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface[]
     */
    public function getOrganizationsAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_organization.repository.organization')->findByParticipant(
            $this->getUser(),
            ['name' => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the organization for given id.
     *
     * @param Request $request        The request
     * @param string  $organizationId The id of organization
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"organization"})
     * @Organization()
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface
     */
    public function getOrganizationAction(Request $request, $organizationId)
    {
        return $request->get('organization');
    }

    /**
     * Creates new organization for name given.
     *
     * @param Request $request The request
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"organization"})
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface
     */
    public function postOrganizationsAction(Request $request)
    {
        return $this->get('kreta_organization.form_handler.organization')->processForm($request);
    }

    /**
     * Updates the organization of id given.
     *
     * @param Request $request        The request
     * @param string  $organizationId The organization id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"organization"})
     * @Organization("edit")
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface
     */
    public function putOrganizationsAction(Request $request, $organizationId)
    {
        return $this->get('kreta_organization.form_handler.organization')->processForm(
            $request, $request->get('organization'), ['method' => 'PUT']
        );
    }

    /**
     * Returns all the projects of given organization, it admits limit and offset.
     *
     * @param Request      $request        The request
     * @param ParamFetcher $paramFetcher   The param fetcher
     * @param string       $organizationId The organization id
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"projectList"})
     * @Organization()
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function getOrganizationProjectsAction(Request $request, ParamFetcher $paramFetcher, $organizationId)
    {
        return $this->get('kreta_project.repository.project')->findByParticipant(
            $this->getUser(),
            $request->get('organization'),
            ['name' => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }
}
