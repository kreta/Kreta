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
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ProjectController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
 */
class ProjectController extends AbstractRestController
{
    /**
     * Returns all the projects of current user, it admits ordering, count and pagination.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="order", requirements="(name|shortName)", default="name", description="Order")
     * @QueryParam(name="count", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="page", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(
     *  description = "Returns all the projects of current user, it admits ordering, count and pagination",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProjectsAction(ParamFetcher $paramFetcher)
    {
        return $this->getAll(
            $this->getCurrentUser(), $paramFetcher, ['projectList'], 'findByParticipant'
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
     *    404 = {
     *        "Does not exist any project with <$id> id"
     *    }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProjectAction($projectId)
    {
        return $this->createResponse($this->getProjectIfAllowed($projectId), ['project']);
    }

    /**
     * Creates new project for name and shortName given.
     *
     * @ApiDoc(
     *  description = "Creates new project for name, shortName and statuses given",
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
     *      201 = "Successfully created",
     *      400 = {
     *          "Name should not be blank",
     *          "ShortName should not be blank",
     *          "Date is not valid"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postProjectsAction()
    {
        return $this->post(
            $this->get('kreta_api.form_handler.project'),
            $this->get('kreta_project.factory.project')->create($this->getCurrentUser()),
            ['project']
        );
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
     *      404 = {
     *          "Does not exist any project with <$id> id"
     *      }
     *  }
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putProjectsAction($projectId)
    {
        return $this->put(
            $this->get('kreta_api.form_handler.project'),
            $this->getProjectIfAllowed($projectId, 'edit'),
            ['project']
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_project.repository.project');
    }
}
