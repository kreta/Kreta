<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WorkflowBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class StatusTransitionController.
 *
 * @package Kreta\Bundle\WorkflowBundle\Controller
 */
class StatusTransitionController extends RestController
{
    /**
     * Returns all the transitions of workflow id given.
     *
     * @param string $workflowId The workflow id
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"transitionList"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    public function getTransitionsAction($workflowId)
    {
        return $this->getWorkflowIfAllowed($workflowId)->getStatusTransitions();
    }

    /**
     * Returns the transition of workflow id and status transition id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The status transition id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    public function getTransitionAction($workflowId, $transitionId)
    {
        return $this->getTransitionIfAllowed($workflowId, $transitionId);
    }

    /**
     * Creates new transition for name, status and initial statuses given.
     *
     * @param string $workflowId The workflow id
     *
     * @ApiDoc(statusCodes = {201, 400, 403, 404})
     * @View(statusCode=201, serializerGroups={"transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    public function postTransitionsAction($workflowId)
    {
        $workflow = $this->getWorkflowIfAllowed($workflowId, 'manage_status');

        return $this->get('kreta_workflow.form_handler.status_transition')->processForm(
            $this->get('request'), null, ['workflow' => $workflow]
        );
    }

    /**
     * Deletes the transition of workflow id and transition id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(statusCodes = {204, 403, 404, 409})
     * @View(statusCode=204)
     *
     * @return void
     * @throws \Kreta\Component\Core\Exception\ResourceInUseException
     */
    public function deleteTransitionAction($workflowId, $transitionId)
    {
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');
        if ($transition->isInUse()) {
            throw new ResourceInUseException();
        }

        $this->get('kreta_workflow.repository.status_transition')->remove($transition);
    }

    /**
     * Returns initial statuses of transition id and workflow id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Http\Get("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses")
     * @View(statusCode=200, serializerGroups={"transitionList", "transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function getTransitionsInitialStatusesAction($workflowId, $transitionId)
    {
        return $this->getTransitionIfAllowed($workflowId, $transitionId)->getInitialStates();
    }

    /**
     * Returns the initial status of status initial id, transition id and workflow id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     * @param string $initialStatusId The initial status id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Http\Get("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses/{initialStatusId}")
     * @View(statusCode=200, serializerGroups={"transitionList", "transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        return $this->getTransitionIfAllowed($workflowId, $transitionId)->getInitialState($initialStatusId);
    }

    /**
     * Creates an initial status of transition id and workflow id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(statusCodes={201, 400, 403, 404, 409})
     * @Http\Post("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses")
     * @View(statusCode=201, serializerGroups={"transitionList", "transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function postTransitionsInitialStatusAction($workflowId, $transitionId)
    {
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');
        if (($initialStatusId = $this->get('request')->get('initial_status')) === null) {
            throw new BadRequestHttpException('The initial status should not be blank');
        }
        $initialStatus = $this->get('kreta_workflow.repository.status')->find($initialStatusId, false);
        $this->get('kreta_workflow.repository.status_transition')->persistInitialStatus($transition, $initialStatus);

        return $transition->getInitialStates();
    }

    /**
     * Deletes the initial status of workflow id, transition id and initial status id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     * @param string $initialStatusId The initial status id
     *
     * @ApiDoc(statusCodes={204, 403, 404, 409={
     *  "The resource is currently in use", "The collection already has the minimum elements that is supported"
     * }})
     * @Http\Delete("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses/{initialStatusId}")
     * @View(statusCode=204)
     *
     * @return void
     * @throws \Kreta\Component\Core\Exception\ResourceInUseException
     */
    public function deleteTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');
        if ($transition->isInUse()) {
            throw new ResourceInUseException();
        }
        $this->get('kreta_workflow.repository.status_transition')->removeInitialStatus($transition, $initialStatusId);
    }

    /**
     * Returns the end status of transition id and workflow id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Http\Get("/workflows/{workflowId}/transitions/{transitionId}/end-status")
     * @View(statusCode=200, serializerGroups={"transitionList", "transition"})
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getTransitionsEndStatusAction($workflowId, $transitionId)
    {
        return $this->getTransitionIfAllowed($workflowId, $transitionId)->getState();
    }

    /**
     * Gets the status transition if the current user is granted and if the workflow exists.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     * @param string $grant        The grant, by default 'view'
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    protected function getTransitionIfAllowed($workflowId, $transitionId, $grant = 'view')
    {
        $this->getWorkflowIfAllowed($workflowId, $grant);

        return $this->get('kreta_workflow.repository.status_transition')->find($transitionId, false);
    }
}
