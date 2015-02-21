<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class TimeEntryController.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Controller
 */
class TimeEntryController extends RestController
{
    /**
     * Returns all time entries of project id and issue id given, it admits sort, limit and offset.
     *
     * @param string                               $projectId    The project id
     * @param string                               $issueId      The issue id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(dateReported|timeSpent)", default="dateReported", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of time entries to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(
     *  description = "Returns all time entries of project id and issue id given, it admits sort, limit and offset",
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
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     * @Get("/projects/{projectId}/issues/{issueId}/time-entries")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"timeEntryList"}
     * )
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface[]
     */
    public function getTimeEntriesAction($projectId, $issueId, ParamFetcher $paramFetcher)
    {
        $issue = $this->getIssueIfAllowed($projectId, $issueId);

        return $this->get('kreta_time_tracking.repository.time_entry')->findByIssue(
            $issue,
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the time entry of project id and issue id and time entry id given.
     *
     * @param string $projectId   The project id
     * @param string $issueId     The issue id
     * @param string $timeEntryId The time entry id
     *
     * @ApiDoc(
     *  description = "Returns the time entry of project id and issue id and time entry id given",
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
     * @Get("/projects/{projectId}/issues/{issueId}/time-entries/{timeEntryId}")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"timeEntry"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getTimeEntryAction($projectId, $issueId, $timeEntryId)
    {
        return $this->getTimeEntryIfAllowed($projectId, $issueId, $timeEntryId);
    }

//    /**
//     * Creates new issue for title, description, type priority and assignee given.
//     *
//     * @param string $projectId The project id
//     *
//     * @ApiDoc(
//     *  description = "Creates new issue for title, description, type, priority and assignee given",
//     *  input = "Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType",
//     *  output = "Kreta\Component\Issue\Model\Interfaces\IssueInterface",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *      201 = "<data>",
//     *      400 = {
//     *          "Title should not be blank",
//     *          "Priority should not be blank",
//     *          "Type should not be blank",
//     *          "Assignee should not be blank",
//     *          "An issue with identical title is already exist in this project",
//     *          "Priority is not valid",
//     *          "Type is not valid",
//     *          "Assignee is not valid",
//     *      },
//     *      403 = "Not allowed to access this resource",
//     *      404 = "Does not exist any object with id passed"
//     *  }
//     * )
//     *
//     * @View(
//     *  statusCode=201,
//     *  serializerGroups={"issue"}
//     * )
//     *
//     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
//     */
//    public function postIssuesAction($projectId)
//    {
//        $project = $this->getProjectIfAllowed($projectId, 'create_issue');
//
//        return $this->get('kreta_issue.form_handler.api.issue')->processForm(
//            $this->get('request'), null, ['project' => $project]
//        );
//    }
//
//    /**
//     * Updates the issue of project id and id given.
//     *
//     * @param string $projectId The project id
//     * @param string $issueId   The issue id
//     *
//     * @ApiDoc(
//     *  description = "Updates the issue of project id and id given",
//     *  input = "Kreta\Bundle\IssueBundle\Form\Type\Api\IssueType",
//     *  output = "Kreta\Component\Issue\Model\Interfaces\IssueInterface",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *      200 = "<data>",
//     *      400 = {
//     *          "Title should not be blank",
//     *          "Priority should not be blank",
//     *          "Type should not be blank",
//     *          "Assignee should not be blank",
//     *          "An issue with identical title is already exist in this project",
//     *          "Priority is not valid",
//     *          "Type is not valid",
//     *          "Assignee is not valid",
//     *      },
//     *      403 = "Not allowed to access this resource",
//     *      404 = "Does not exist any object with id passed"
//     *  }
//     * )
//     *
//     * @View(
//     *  statusCode=200,
//     *  serializerGroups={"issue"}
//     * )
//     *
//     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
//     */
//    public function putIssuesAction($projectId, $issueId)
//    {
//        $issue = $this->getIssueIfAllowed($projectId, $issueId, 'view', 'edit');
//
//        return $this->get('kreta_issue.form_handler.api.issue')->processForm(
//            $this->get('request'), $issue, ['method' => 'PUT', 'project' => $issue->getProject()]
//        );
//    }

    /**
     * Gets the time entry if the current user is granted and if the time entry exists.
     *
     * @param string $projectId      The project id
     * @param string $issueId        The issue id
     * @param string $timeEntryId    The time entry id
     * @param string $projectGrant   The project grant
     * @param string $issueGrant     The issue grant
     * @param string $timeEntryGrant The time entry grant
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    protected function getTimeEntryIfAllowed(
        $projectId,
        $issueId,
        $timeEntryId,
        $projectGrant = 'view',
        $issueGrant = 'view',
        $timeEntryGrant = 'view'
    )
    {
        $this->getIssueIfAllowed($projectId, $issueId, $projectGrant, $issueGrant);

        return $this->getResourceIfAllowed(
            $this->get('kreta_time_tracking.repository.time_entry'),
            $timeEntryId,
            $timeEntryGrant
        );
    }
}
