<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;

/**
 * Class ProjectController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class ProjectController extends RestController
{
    /**
     * Returns all the projects of current user, it admits sort, limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(name|shortName)", default="name", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200})
     * @View(statusCode=200, serializerGroups={"projectList"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function getProjectsAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.project')->findByParticipant(
            $this->getUser(),
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the project for given id.
     *
     * @param string $projectId The id of project
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"project"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function getProjectAction($projectId)
    {
        return $this->getProjectIfAllowed($projectId);
    }

    /**
     * Creates new project for name and shortName given.
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"project"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function postProjectsAction()
    {
        return $this->get('kreta_project.form_handler.project')->processForm($this->get('request'));
    }

    /**
     * Updates the project of id given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"project"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function putProjectsAction($projectId)
    {
        return $this->get('kreta_project.form_handler.project')->processForm(
            $this->get('request'), $this->getProjectIfAllowed($projectId, 'edit'), ['method' => 'PUT']
        );
    }
}
