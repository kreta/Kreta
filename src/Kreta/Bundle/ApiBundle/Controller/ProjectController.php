<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ProjectController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
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
     * @ApiDoc(
     *  description = "Returns all the projects of current user, it admits sort, limit and offset",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  resource = true,
     *  statusCodes = {
     *    200 = "<data>"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"projectList"}
     * )
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
     * @ApiDoc(
     *  description = "Returns the project for given id",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    200 = "<data>",
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"project"}
     * )
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
     * @ApiDoc(
     *  description = "Creates new project for name and shortName given",
     *  input = "Kreta\Bundle\ApiBundle\Form\Type\ProjectType",
     *  output = "Kreta\Component\Project\Model\Interfaces\ProjectInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      201 = "<data>",
     *      400 = {
     *          "Name should not be blank",
     *          "ShortName should not be blank"
     *      }
     *  }
     * )
     *
     * @View(
     *  statusCode=201,
     *  serializerGroups={"project"}
     * )
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function postProjectsAction()
    {
        return $this->get('kreta_api.form_handler.project')->processForm($this->get('request'));
    }

    /**
     * Updates the project of id given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(
     *  description = "Updates the project of id given",
     *  input = "Kreta\Bundle\ApiBundle\Form\Type\ProjectType",
     *  output = "Kreta\Component\Project\Model\Interfaces\ProjectInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      200 = "Successfully updated",
     *      400 = {
     *          "Name should not be blank",
     *          "Short name should not be blank",
     *          "Short name max length is 4",
     *          "Short name is already in use"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"project"}
     * )
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function putProjectsAction($projectId)
    {
        return $this->get('kreta_api.form_handler.project')->processForm(
            $this->get('request'), $this->getProjectIfAllowed($projectId, 'edit'), ['method' => 'PUT']
        );
    }
}
