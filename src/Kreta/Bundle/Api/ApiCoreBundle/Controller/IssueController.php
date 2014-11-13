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
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Util\CamelCaser;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class IssueController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class IssueController extends ResourceController
{
    /**
     * The name of class.
     *
     * @var string
     */
    protected $class = 'issue';

    /**
     * The name of bundle.
     *
     * @var string
     */
    protected $bundle = 'core';

    /**
     * Returns all the projects of current user, it admits ordering, count, pagination and filtering.
     *
     * @param string                               $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="order", requirements="(createdAt|title)", strict=true, default="createdAt", description="Order")
     * @QueryParam(name="assignee", requirements="(.*)", strict=true, nullable=true, description="Assignee's email filter")
     * @QueryParam(name="reporter", requirements="(.*)", strict=true, nullable=true, description="Reporter's email filter")
     * @QueryParam(name="watcher", requirements="(.*)", strict=true, nullable=true, description="Watcher's email filter")
     * @QueryParam(name="priority", requirements="(.*)", strict=true, nullable=true, description="Priority filter")
     * @QueryParam(name="status", requirements="(.*)", strict=true, nullable=true, description="Status' name filter")
     * @QueryParam(name="type", requirements="(.*)", strict=true, nullable=true, description="Type filter")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Title filter")
     * @QueryParam(name="count", requirements="\d+", default="9999", description="Amount of issues to be returned")
     * @QueryParam(name="page", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(
     *  description = "Returns all the projects of current user, it admits ordering, count, pagination and filtering",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any project with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIssuesAction($projectId, ParamFetcher $paramFetcher)
    {
        $project = $this->get('kreta_core.repository_project')->findOneById($projectId);
        if (!$project instanceof ProjectInterface) {
            throw new NotFoundHttpException('Does not exist any project with ' . $projectId . ' id');
        }

        if (!$this->get('security.context')->isGranted('view', $project)) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }
        $resources = $this->get('kreta_' . $this->bundle . '.repository_' . $this->class)
            ->findByProject(
                $project,
                array(CamelCaser::underscoreToCamelCase($paramFetcher->get('order')) => 'ASC'),
                $paramFetcher->get('count'),
                $paramFetcher->get('page'),
                array(
                    'title'     => $paramFetcher->get('q'),
                    'a.email'   => $paramFetcher->get('assignee'),
                    'rep.email' => $paramFetcher->get('reporter'),
                    'w.email'   => $paramFetcher->get('watcher'),
                    'priority'  => $paramFetcher->get('priority'),
                    's.name'    => $paramFetcher->get('status'),
                    'type'      => $paramFetcher->get('type')
                )
            );

        return $this->handleView($this->createView($resources, array('issueList')));
    }

//    /**
//     * Returns the project for given id.
//     *
//     * @param string $id The id of project
//     *
//     * @ApiDoc(
//     *  description = "Returns the project for given id",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *    404 = "Does not exist any project with <$id> id"
//     *  }
//     * )
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function getProjectAction($id)
//    {
//        return $this->handleView($this->createView($this->getProjectIfExistsAndIfIsGranted($id), array('project')));
//    }
//
//    /**
//     * Creates new project for name, shortName and statuses given.
//     * The statuses is a collection of status and by default contains three of them: to do, doing and done.
//     *
//     * @ApiDoc(
//     *  description = "Creates new project for name, shortName and statuses given",
//     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType",
//     *  output = "Kreta\Component\Core\Model\Interfaces\ProjectInterface",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *      200 = "Successfully created",
//     *      400 = {
//     *          "Name should not be blank",
//     *          "ShortName should not be blank",
//     *          "Date is not valid"
//     *      },
//     *  }
//     * )
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function postProjectsAction()
//    {
//        $project = $this->get('kreta_core.factory_project')->create();
//        $participant = $this->get('kreta_core.factory_participant')
//            ->create($project, $this->getCurrentUser(), 'ROLE_ADMIN');
//        $project->addParticipant($participant);
//
//        return $this->manageForm(new ProjectType(), $project, array('project'));
//    }
//
//    /**
//     * Updates the project of id given.
//     *
//     * @param string $id The project id
//     *
//     * @ApiDoc(
//     *  description = "Updates the project of id given",
//     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType",
//     *  output = "Kreta\Component\Core\Model\Interfaces\ProjectInterface",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *      200 = "Successfully updated",
//     *      400 = {
//     *          "Name should not be blank",
//     *          "Short name should not be blank",
//     *          "Short name max length is 4",
//     *          "Short name is already in use"
//     *      },
//     *      403 = "Not allowed to access this resource",
//     *      404 = "Does not exist any project with <$id> id"
//     *  }
//     * )
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function putProjectsAction($id)
//    {
//        return $this->manageForm(
//            new ProjectType(), $this->getProjectIfExistsAndIfIsGranted($id, 'edit'), array('project')
//        );
//    }
//
////    /**
////     * Deletes the project of id given.
////     *
////     * @param string $id The project id
////     *
////     * @ApiDoc(
////     *  description = "Deletes the project of id given",
////     *  requirements = {
////     *    {
////     *      "name"="_format",
////     *      "requirement"="json|jsonp",
////     *      "description"="Supported formats, by default json"
////     *    }
////     *  },
////     *  statusCodes = {
////     *      204 = "Successfully removed",
////     *      403 = "Not allowed to access this resource",
////     *      404 = "Does not exist any project with <$id> id"
////     *  }
////     * )
////     *
////     * @return \Symfony\Component\HttpFoundation\Response
////     */
////    public function deleteProjectsAction($id)
////    {
////        $project = $this->getProjectIfExistsAndIfIsGranted($id, 'delete');
////        $manager = $this->getDoctrine()->getManager();
////        $manager->remove($project);
////        $manager->flush();
////
////        return $this->handleView($this->createView('The project is successfully removed', null, 204));
////    }
//
//    /**
//     * Gets the project if the current user is granted and if the project exists.
//     *
//     * @param string $id    The id
//     * @param string $grant The grant, by default view
//     *
//     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
//     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
//     */
//    protected function getProjectIfExistsAndIfIsGranted($id, $grant = 'view')
//    {
//        $project = $this->getResourceIfExists($id);
//        if ($this->get('security.context')->isGranted($grant, $project) === false) {
//            throw new AccessDeniedException('Not allowed to access this resource');
//        }
//
//        return $project;
//    }
}
