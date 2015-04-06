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
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Project;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IssueTypeController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class IssueTypeController extends Controller
{
    /**
     * Returns all issue types, it admits sort, limit and offset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher      $paramFetcher The param fetcher
     *
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Name filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of issue types to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @Http\Get("/projects/{projectId}/issue-types")
     * @View(statusCode=200, serializerGroups={"issueTypeList"})
     * @Project()
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface[]
     */
    public function getIssueTypesAction(Request $request, $projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.issue_type')->findByProject(
            $request->get('project'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new issue type for name given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     * @param string                                    $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @Http\Post("/projects/{projectId}/issue-types")
     * @View(statusCode=201, serializerGroups={"issueType"})
     * @Project("create_issue_type")
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface
     */
    public function postIssueTypesAction(Request $request, $projectId)
    {
        return $this->get('kreta_project.form_handler.issue_type')->processForm(
            $request, null, ['project' => $request->get('project')]
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
     * @Project("delete_issue_type")
     *
     * @return void
     */
    public function deleteIssueTypesAction($projectId, $issueTypeId)
    {
        $repository = $this->get('kreta_project.repository.issue_type');
        $issueType = $repository->find($issueTypeId, false);
        $repository->remove($issueType);
    }
}
