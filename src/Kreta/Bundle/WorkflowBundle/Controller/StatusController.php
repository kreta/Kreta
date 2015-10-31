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

namespace Kreta\Bundle\WorkflowBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Workflow;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusController.
 *
 * @package Kreta\Bundle\WorkflowBundle\Controller
 */
class StatusController extends Controller
{
    /**
     * Returns all the statuses of workflow id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"statusList"})
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function getStatusesAction(Request $request, $workflowId)
    {
        return $request->get('workflow')->getStatuses();
    }

    /**
     * Returns the status of id and workflow id given.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"status"})
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getStatusAction($workflowId, $statusId)
    {
        return $this->get('kreta_workflow.repository.status')->find($statusId, false);
    }

    /**
     * Creates new status for name, color and type given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(statusCodes={201, 400, 403, 404})
     * @View(statusCode=201, serializerGroups={"status"})
     * @Workflow("manage_status")
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function postStatusesAction(Request $request, $workflowId)
    {
        return $this->get('kreta_workflow.form_handler.status')->processForm(
            $request, null, ['workflow' => $request->get('workflow')]
        );
    }

    /**
     * Updates the status of workflow id and status id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     * @param string                                    $statusId   The status id
     *
     * @ApiDoc(statusCodes={200, 400, 403, 404})
     * @View(statusCode=200, serializerGroups={"status"})
     * @Workflow("manage_status")
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function putStatusesAction(Request $request, $workflowId, $statusId)
    {
        $status = $this->get('kreta_workflow.repository.status')->find($statusId, false);

        return $this->get('kreta_workflow.form_handler.status')->processForm($request, $status, ['method' => 'PUT']);
    }

    /**
     * Deletes the status and its associate transitions of workflow id and id given.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     *
     * @ApiDoc(statusCodes={204, 403, 404, 409})
     * @View(statusCode=204)
     * @Workflow("manage_status")
     *
     * @return void
     * @throws \Kreta\Component\Core\Exception\ResourceInUseException
     */
    public function deleteStatusesAction($workflowId, $statusId)
    {
        $repository = $this->get('kreta_workflow.repository.status');
        $status = $repository->find($statusId, false);
        if ($status->isInUse()) {
            throw new ResourceInUseException();
        }
        $repository->remove($status);
    }
}
