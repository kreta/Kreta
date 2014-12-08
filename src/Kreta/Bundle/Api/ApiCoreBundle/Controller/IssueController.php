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
use Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType;
use Kreta\Component\Core\Util\CamelCaser;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class IssueController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class IssueController extends AbstractRestController
{
    /**
     * Returns all the projects of current user, it admits ordering, count, pagination and filtering.
     *
     * @param string                               $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="order", requirements="(created-at|title)", strict=true, default="created-at", description="Order")
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
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIssuesAction($projectId, ParamFetcher $paramFetcher)
    {
        $resources = $this->getRepository()->findByProject(
            $this->getProjectIfAllowed($projectId, 'view'),
            [CamelCaser::underscoreToCamelCase($paramFetcher->get('order')) => 'ASC'],
            $paramFetcher->get('count'),
            $paramFetcher->get('page'),
            [
                'title'     => $paramFetcher->get('q'),
                'a.email'   => $paramFetcher->get('assignee'),
                'rep.email' => $paramFetcher->get('reporter'),
                'w.email'   => $paramFetcher->get('watcher'),
                'priority'  => $paramFetcher->get('priority'),
                's.name'    => $paramFetcher->get('status'),
                'type'      => $paramFetcher->get('type')
            ]
        );

        return $this->createResponse($resources, ['issueList']);
    }

    /**
     * Returns the issue of id and project id given.
     *
     * @ApiDoc(
     *  description = "Returns the issue of id and project id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any project with <$id> id",
     *    404 = "Does not exist any issue with <$id> id"
     *  }
     * )
     *
     * @param string $projectId The project if
     * @param string $id        The status id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIssueAction($projectId, $id)
    {
        return $this->createResponse($this->getIssueIfAllowed($id), ['issue']);
    }

    /**
     * Creates new issue for title, description, type priority and assignee given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(
     *  description = "Creates new issue for title, description, type, priority and assignee given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType",
     *  output = "Kreta\Component\Core\Model\Interfaces\IssueInterface",
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
     *          "Title should not be blank",
     *          "Priority should not be blank",
     *          "Type should not be blank",
     *          "Assignee should not be blank",
     *          "An issue with identical title is already exist in this project",
     *          "Priority is not valid",
     *          "Type is not valid",
     *          "Assignee is not valid",
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any project with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postIssuesAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId, 'create_issue');
        $issue = $this->get('kreta_core.factory_issue')->create($project, $this->getCurrentUser());

        return $this->manageForm(new IssueType($project->getParticipants()), $issue, ['issue']);
    }

    /**
     * Updates the issue of project id and id given.
     *
     * @param string $projectId The project id
     * @param string $id        The project id
     *
     * @ApiDoc(
     *  description = "Updates the issue of project id and id given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType",
     *  output = "Kreta\Component\Core\Model\Interfaces\IssueInterface",
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
     *          "Title should not be blank",
     *          "Priority should not be blank",
     *          "Type should not be blank",
     *          "Assignee should not be blank",
     *          "An issue with identical title is already exist in this project",
     *          "Priority is not valid",
     *          "Type is not valid",
     *          "Assignee is not valid",
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any issue with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putIssuesAction($projectId, $id)
    {
        $project = $this->getProjectIfAllowed($projectId, 'view');

        return $this->manageForm(
            new IssueType($project->getParticipants()),
            $this->getIssueIfAllowed($id, 'edit'),
            ['issue']
        );
    }

    /**
     * Gets the issue if the current user is granted and if the project exists.
     *
     * @param string $id    The id
     * @param string $grant The grant, by default view
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface
     */
    protected function getIssueIfAllowed($id, $grant = 'view')
    {
        $issue = $this->getResourceIfExists($id);
        if (!$this->get('security.context')->isGranted($grant, $issue)) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }

        return $issue;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_core.repository_issue');
    }
}
