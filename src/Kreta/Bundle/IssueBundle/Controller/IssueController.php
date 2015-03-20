<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class IssueController.
 *
 * @package Kreta\Bundle\IssueBundle\Controller
 */
class IssueController extends RestController
{
    /**
     * Returns all issues, it admits sort, limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(title|createdAt)", default="title", description="Sort")
     * @QueryParam(name="project", requirements="(.*)", strict=true, nullable=true, description="Project's name filter")
     * @QueryParam(name="assignee", requirements="(.*)", strict=true, nullable=true, description="Assignee's email filter")
     * @QueryParam(name="reporter", requirements="(.*)", strict=true, nullable=true, description="Reporter's email filter")
     * @QueryParam(name="watcher", requirements="(.*)", strict=true, nullable=true, description="Watcher's email filter")
     * @QueryParam(name="priority", requirements="(.*)", strict=true, nullable=true, description="Priority filter")
     * @QueryParam(name="status", requirements="(.*)", strict=true, nullable=true, description="Status' name filter")
     * @QueryParam(name="type", requirements="(.*)", strict=true, nullable=true, description="Type filter")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Title filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of issues to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(
     *  description = "Returns all issues, it admits sort, limit and offset",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  resource = true,
     *  statusCodes = {
     *    200 = "<data>",
     *    403 = "Not allowed to access this resource"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"issueList"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getIssuesAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_issue.repository.issue')->findByParticipant(
            $this->getUser(),
            [
                'title'       => $paramFetcher->get('q'),
                'p.shortName' => $paramFetcher->get('project'),
                'a.email'     => $paramFetcher->get('assignee'),
                'rep.email'   => $paramFetcher->get('reporter'),
                'w.email'     => $paramFetcher->get('watcher'),
                'priority'    => $paramFetcher->get('priority'),
                's.name'      => strtolower($paramFetcher->get('status')),
                'type'        => $paramFetcher->get('type')
            ],
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the issue of id given.
     *
     * @param string $issueId The issue id
     *
     * @ApiDoc(
     *  description = "Returns the issue of id given",
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
     *  serializerGroups={"issue"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getIssueAction($issueId)
    {
        return $this->getIssueIfAllowed($issueId);
    }

    /**
     * Creates new issue for title, description, type priority and assignee given.
     *
     * @ApiDoc(
     *  description = "Creates new issue for title, project, description, type, priority and assignee given",
     *  input = "Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType",
     *  output = "Kreta\Component\Issue\Model\Interfaces\IssueInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    201 = "<data>",
     *    400 = {
     *      "Title should not be blank",
     *      "Priority should not be blank",
     *      "Type should not be blank",
     *      "Project should not be blank",
     *      "Assignee should not be blank",
     *      "An issue with identical title is already exist in this project",
     *      "Priority is not valid",
     *      "Type is not valid",
     *      "Project is not valid",
     *      "Assignee is not valid"
     *    },
     *    403 = "Not allowed to access this resource"
     *  }
     * )
     *
     * @View(
     *  statusCode=201,
     *  serializerGroups={"issue"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function postIssuesAction()
    {
        $projects = $this->get('kreta_project.repository.project')->findByParticipant($this->getUser());

        return $this->get('kreta_issue.form_handler.issue')
            ->processForm($this->get('request'), null, ['projects' => $projects]);
    }

    /**
     * Updates the issue of id given.
     *
     * @param string $issueId The issue id
     *
     * @ApiDoc(
     *  description = "Updates the issue of id given",
     *  input = "Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType",
     *  output = "Kreta\Component\Issue\Model\Interfaces\IssueInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    200 = "<data>",
     *    400 = {
     *      "Title should not be blank",
     *      "Priority should not be blank",
     *      "Type should not be blank",
     *      "Assignee should not be blank",
     *      "Project should not be blank",
     *      "An issue with identical title is already exist in this project",
     *      "Priority is not valid",
     *      "Type is not valid",
     *      "Project is not valid",
     *      "Assignee is not valid"
     *    },
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"issue"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function putIssuesAction($issueId)
    {
        $issue = $this->getIssueIfAllowed($issueId, 'edit');
        $projects = $this->get('kreta_project.repository.project')->findByParticipant($this->getUser());

        return $this->get('kreta_issue.form_handler.issue')->processForm(
            $this->get('request'), $issue, ['method' => 'PUT', 'projects' => $projects]
        );
    }
}
