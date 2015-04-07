<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WorkflowBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Workflow;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WorkflowController.
 *
 * @package Kreta\Bundle\WorkflowBundle\Controller
 */
class WorkflowController extends Controller
{
    /**
     * Returns all the workflows of current user, it admits sort, limit and offset.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="sort", requirements="(name|createdAt)", default="name", description="Sort")
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of workflows to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     *
     * @ApiDoc(resource=true, statusCodes={200})
     * @View(statusCode=200, serializerGroups={"workflowList"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface[]
     */
    public function getWorkflowsAction(ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_workflow.repository.workflow')->findBy(
            ['creator' => $this->getUser()],
            [$paramFetcher->get('sort') => 'ASC'],
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
    }

    /**
     * Returns the workflow of id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"workflow"})
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function getWorkflowAction(Request $request, $workflowId)
    {
        return $request->get('workflow');
    }

    /**
     * Creates new workflow for name given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"workflow"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function postWorkflowAction(Request $request)
    {
        return $this->get('kreta_workflow.form_handler.workflow')->processForm($request);
    }

    /**
     * Updates the workflow of id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"workflow"})
     * @Workflow("edit")
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function putWorkflowAction(Request $request, $workflowId)
    {
        return $this->get('kreta_workflow.form_handler.workflow')->processForm(
            $request, $request->get('workflow'), ['method' => 'PUT']
        );
    }
}
