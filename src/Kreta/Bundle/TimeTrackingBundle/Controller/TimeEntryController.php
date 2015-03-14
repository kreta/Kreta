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
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
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
     * Returns all time entries of issue id given, it admits sort, limit and offset.
     *
     * @param string                               $issueId      The issue id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(dateReported|timeSpent)", default="dateReported", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of time entries to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(
     *  description = "Returns all time entries of issue id given, it admits sort, limit and offset",
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
     * @Get("/issues/{issueId}/time-entries")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"timeEntryList"}
     * )
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface[]
     */
    public function getTimeEntriesAction($issueId, ParamFetcher $paramFetcher)
    {
        $issue = $this->getIssueIfAllowed($issueId);

        return $this->get('kreta_time_tracking.repository.time_entry')->findByIssue(
            $issue,
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the time entry of issue id and time entry id given.
     *
     * @param string $issueId     The issue id
     * @param string $timeEntryId The time entry id
     *
     * @ApiDoc(
     *  description = "Returns the time entry of issue id and time entry id given",
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
     * @Get("/issues/{issueId}/time-entries/{timeEntryId}")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"timeEntry"}
     * )
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getTimeEntryAction($issueId, $timeEntryId)
    {
        return $this->getTimeEntryIfAllowed($issueId, $timeEntryId);
    }

    /**
     * Creates new time entry for description, and time spent given.
     *
     * @param string $issueId The issue id
     *
     * @ApiDoc(
     *  description = "Creates new time entry for description, and time spent given",
     *  input = "Kreta\Bundle\TimeTrackingBundle\Form\Type\TimeEntryType",
     *  output = "Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      201 = "<data>",
     *      400 = "Time spent should not be blank",
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @Post("/issues/{issueId}/time-entries")
     *
     * @View(
     *  statusCode=201,
     *  serializerGroups={"timeEntry"}
     * )
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    public function postTimeEntriesAction($issueId)
    {
        $issue = $this->getIssueIfAllowed($issueId);

        return $this->get('kreta_time_tracking.form_handler.time_entry')->processForm(
            $this->get('request'), null, ['issue' => $issue]
        );
    }

    /**
     * Updates the time entry of issue id, and id given.
     *
     * @param string $issueId     The issue id
     * @param string $timeEntryId The time entry id
     *
     * @ApiDoc(
     *  description = "Updates the time entry of issue id, and id given",
     *  input = "Kreta\Bundle\TimeTrackingBundle\Form\Type\TimeEntryType",
     *  output = "Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      200 = "<data>",
     *      400 = "Time spent should not be blank",
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @Put("/issues/{issueId}/time-entries/{timeEntryId}")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"timeEntry"}
     * )
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    public function putTimeEntriesAction($issueId, $timeEntryId)
    {
        $timeEntry = $this->getTimeEntryIfAllowed($issueId, $timeEntryId, 'view', 'edit');

        return $this->get('kreta_time_tracking.form_handler.time_entry')->processForm(
            $this->get('request'), $timeEntry, ['method' => 'PUT', 'issue' => $timeEntry->getIssue()]
        );
    }

    /**
     * Deletes the time entry of issue id, and id given.
     *
     * @param string $issueId     The issue id
     * @param string $timeEntryId The time entry id
     *
     * @ApiDoc(
     *  description = "Deletes the time entry of issue id, and id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      200 = "<data>",
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @Delete("/issues/{issueId}/time-entries/{timeEntryId}")
     *
     * @View(statusCode=204)
     *
     * @return void
     */
    public function deleteTimeEntriesAction($issueId, $timeEntryId)
    {
        $timeEntry = $this->getTimeEntryIfAllowed($issueId, $timeEntryId, 'view', 'delete');
        $this->get('kreta_time_tracking.repository.time_entry')->remove($timeEntry);
    }

    /**
     * Gets the time entry if the current user is granted and if the time entry exists.
     *
     * @param string $issueId        The issue id
     * @param string $timeEntryId    The time entry id
     * @param string $issueGrant     The issue grant
     * @param string $timeEntryGrant The time entry grant
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    protected function getTimeEntryIfAllowed(
        $issueId,
        $timeEntryId,
        $issueGrant = 'view',
        $timeEntryGrant = 'view'
    )
    {
        $this->getIssueIfAllowed($issueId, $issueGrant);

        return $this->getResourceIfAllowed(
            $this->get('kreta_time_tracking.repository.time_entry'),
            $timeEntryId,
            $timeEntryGrant
        );
    }
}
