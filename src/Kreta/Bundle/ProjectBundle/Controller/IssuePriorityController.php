<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
 * Class PriorityController
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssuePriorityController extends Controller
{
    /**
     * Returns all priorities, it admits sort, limit and offset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher      $paramFetcher The param fetcher
     *
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Name filter")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of priorities to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @Http\Get("/projects/{projectId}/issue-priorities")
     * @View(statusCode=200, serializerGroups={"issuePriorityList"})
     * @Project()
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface[]
     */
    public function getIssuePrioritiesAction(Request $request, $projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.issue_priority')->findByProject(
            $request->get('project'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new priority for name given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     * @param string                                    $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @Http\Post("/projects/{projectId}/issue-priorities")
     * @View(statusCode=201, serializerGroups={"issuePriority"})
     * @Project("create_priority")
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface
     */
    public function postIssuePrioritiesAction(Request $request, $projectId)
    {
        return $this->get('kreta_project.form_handler.issue_priority')->processForm(
            $request, null, ['project' => $request->get('project')]
        );
    }

    /**
     * Deletes priority of project id and priority id given.
     *
     * @param string $projectId  The project id
     * @param string $priorityId The priority id
     *
     * @ApiDoc(statusCodes={204, 403, 404})
     * @Http\Delete("/projects/{projectId}/issue-priorities/{priorityId}")
     * @View(statusCode=204)
     * @Project("delete_priority")
     */
    public function deleteIssuePrioritiesAction($projectId, $priorityId)
    {
        $repository = $this->get('kreta_project.repository.issue_priority');
        $priority = $repository->find($priorityId, false);
        $repository->remove($priority);
    }
}
