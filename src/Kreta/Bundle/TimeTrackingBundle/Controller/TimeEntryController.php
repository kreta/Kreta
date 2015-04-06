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

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Issue;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as TimeEntry;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TimeEntryController.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Controller
 */
class TimeEntryController extends Controller
{
    /**
     * Returns all time entries of issue id given, it admits sort, limit and offset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $issueId      The issue id
     * @param \FOS\RestBundle\Request\ParamFetcher      $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(dateReported|timeSpent)", default="dateReported", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of time entries to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @Http\Get("/issues/{issueId}/time-entries")
     * @View(statusCode=200, serializerGroups={"timeEntryList"})
     * @Issue()
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface[]
     */
    public function getTimeEntriesAction(Request $request, $issueId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_time_tracking.repository.time_entry')->findByIssue(
            $request->get('issue'),
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the time entry of issue id and time entry id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     The request
     * @param string                                    $issueId     The issue id
     * @param string                                    $timeEntryId The time entry id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Http\Get("/issues/{issueId}/time-entries/{timeEntryId}")
     * @View(statusCode=200, serializerGroups={"timeEntry"})
     * @TimeEntry()
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getTimeEntryAction(Request $request, $issueId, $timeEntryId)
    {
        return $request->get('timeEntry');
    }

    /**
     * Creates new time entry for description, and time spent given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     * @param string                                    $issueId The issue id
     *
     * @ApiDoc(statusCodes={201, 400, 403, 404})
     * @Http\Post("/issues/{issueId}/time-entries")
     * @View(statusCode=201, serializerGroups={"timeEntry"})
     * @Issue()
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    public function postTimeEntriesAction(Request $request, $issueId)
    {
        return $this->get('kreta_time_tracking.form_handler.time_entry')->processForm(
            $request, null, ['issue' => $request->get('issue')]
        );
    }

    /**
     * Updates the time entry of issue id, and id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     The request
     * @param string                                    $issueId     The issue id
     * @param string                                    $timeEntryId The time entry id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @Http\Put("/issues/{issueId}/time-entries/{timeEntryId}")
     * @View(statusCode=200, serializerGroups={"timeEntry"})
     * @TimeEntry("edit")
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    public function putTimeEntriesAction(Request $request, $issueId, $timeEntryId)
    {
        return $this->get('kreta_time_tracking.form_handler.time_entry')->processForm(
            $request, $request->get('timeEntry'), ['method' => 'PUT', 'issue' => $request->get('issue')]
        );
    }

    /**
     * Deletes the time entry of issue id, and id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     The request
     * @param string                                    $issueId     The issue id
     * @param string                                    $timeEntryId The time entry id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Http\Delete("/issues/{issueId}/time-entries/{timeEntryId}")
     * @View(statusCode=204)
     * @TimeEntry("delete")
     *
     * @return void
     */
    public function deleteTimeEntriesAction(Request $request, $issueId, $timeEntryId)
    {
        $this->get('kreta_time_tracking.repository.time_entry')->remove($request->get('timeEntry'));
    }
}
