<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\Api\ApiCoreBundle\Controller\Base\ResourceController;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProjectController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class ProjectController extends ResourceController
{
    /**
     * The name of class.
     *
     * @var string
     */
    protected $class = 'project';

    /**
     * The name of bundle.
     *
     * @var string
     */
    protected $bundle = 'core';

    /**
     * Returns all the projects of current user, it admits ordering, count and pagination.
     *
     * @param ParamFetcher $paramFetcher The param fetcher
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
     *      "description"="Supported formats, by default json."
     *    }
     *  },
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProjectsAction(ParamFetcher $paramFetcher)
    {
        return $this->getAllAuthenticated(
            $this->getCurrentUser(), $paramFetcher, array('projectList'), 'findByParticipant'
        );
    }

    /**
     * Returns the project for given id.
     *
     * @param string $id The id of project
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
     *    404 = "Does not exist any project with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProjectAction($id)
    {
        return $this->handleView($this->createView($this->getProjectIfExistsAndIfIsGranted($id), array('project')));
    }

    /**
     * Creates new project for name, shortName and statuses given.
     * The statuses is a collection of status and by default contains three of them: to do, doing and done.
     *
     * @ApiDoc(
     *  description = "Creates new project for name, shortName and statuses given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType",
     *  output = "Kreta\Component\Core\Model\Interfaces\ProjectInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      200 = "Successfully created",
     *      400 = {
     *          "Name should not be blank",
     *          "ShortName should not be blank",
     *          "Date is not valid"
     *      },
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postProjectsAction()
    {
        $project = $this->get('kreta_core.factory_project')->create();
        $participant = $this->get('kreta_core.factory_participant')
            ->create($project, $this->getCurrentUser(), 'ROLE_ADMIN');
        $project->addParticipant($participant);

        return $this->manageForm(new ProjectType(), $project, array('project'));
    }

    /**
     * Updates the project of id given.
     *
     * @param string $id The project id
     *
     * @ApiDoc(
     *  description = "Updates the project of id given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType",
     *  output = "Kreta\Component\Core\Model\Interfaces\ProjectInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json."
     *    }
     *  },
     *  statusCodes = {
     *      200 = "Successfully updated",
     *      400 = {
     *          "Name should not be blank",
     *          "ShortName should not be blank",
     *          "ShortName max length is 4",
     *          "ShortName is already exists"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Project not found",
     *          "Does not exist any project with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putProjectsAction($id)
    {
        return $this->manageForm(
            new ProjectType(), $this->getProjectIfExistsAndIfIsGranted($id, 'edit'), array('project')
        );
    }

    /**
     * Deletes the project of id given.
     *
     * @param string $id The project id
     *
     * @ApiDoc(
     *  description = "Deletes the project of id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      204 = "Successfully removed",
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Project not found",
     *          "Does not exist any project with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProjectsAction($id)
    {
        $project = $this->getProjectIfExistsAndIfIsGranted($id, 'delete');
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($project);
        $manager->flush();

        return $this->handleView($this->createView('The project is successfully removed', null, 204));
    }

    /**
     * Gets the project if the current user is granted and if the project exists.
     *
     * @param string $id    The id
     * @param string $grant The grant, by default view
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    protected function getProjectIfExistsAndIfIsGranted($id, $grant = 'view')
    {
        $project = $this->getResourceIfExists($id);
        if ($this->get('security.context')->isGranted($grant, $project) === false) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }

        return $project;
    }
}
