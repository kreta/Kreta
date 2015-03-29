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

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;

/**
 * Class IssueTypeController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class IssueTypeController extends RestController
{
    /**
     * Returns all issue types, it admits sort, limit and offset.
     *
     * @param string                               $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Name filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of issue types to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @Http\Get("/projects/{projectId}/issue-types")
     * @View(statusCode=200, serializerGroups={"issueTypeList"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface[]
     */
    public function getIssueTypesAction($projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.issue_type')->findByProject(
            $this->getProjectIfAllowed($projectId),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new issue type for name given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @Http\Post("/projects/{projectId}/issue-types")
     * @View(statusCode=201, serializerGroups={"issueType"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface
     */
    public function postIssueTypesAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId, 'create_issue_type');

        return $this->get('kreta_project.form_handler.issue_type')->processForm(
            $this->get('request'), null, ['project' => $project]
        );
    }

    /**
     * Deletes issue type of project id and issue type id given.
     *
     * @param string $projectId   The project id
     * @param string $issueTypeId The issue type id
     *
     * @ApiDoc(statusCodes={204, 403, 404})
     * @Http\Delete("/projects/{projectId}/issue-types/{issueTypeId}")
     * @View(statusCode=204)
     *
     * @return void
     */
    public function deleteIssueTypesAction($projectId, $issueTypeId)
    {
        $this->getProjectIfAllowed($projectId, 'delete_issue_type');

        $repository = $this->get('kreta_project.repository.issue_type');
        $issueType = $repository->find($issueTypeId, false);
        $repository->remove($issueType);
    }
}
