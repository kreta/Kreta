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

use FOS\RestBundle\Controller\Annotations as Http;
use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Workflow;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class StatusTransitionController.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class StatusTransitionController extends Controller
{
    /**
     * Returns all the transitions of workflow id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"transitionList"})
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    public function getTransitionsAction(Request $request, $workflowId)
    {
        return $request->get('workflow')->getStatusTransitions();
    }

    /**
     * Returns the transition of workflow id and status transition id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The status transition id
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"transition"})
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    public function getTransitionAction($workflowId, $transitionId)
    {
        return $this->getTransition($transitionId);
    }

    /**
     * Creates new transition for name, status and initial statuses given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    The request
     * @param string                                    $workflowId The workflow id
     *
     * @ApiDoc(statusCodes = {201, 400, 403, 404})
     * @View(statusCode=201, serializerGroups={"transition"})
     * @Workflow("manage_status")
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    public function postTransitionsAction(Request $request, $workflowId)
    {
        return $this->get('kreta_workflow.form_handler.status_transition')->processForm(
            $request, null, ['workflow' => $request->get('workflow')]
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
     * @Workflow("manage_status")
     *
     * @throws \Kreta\Component\Core\Exception\ResourceInUseException
     */
    public function deleteTransitionAction($workflowId, $transitionId)
    {
        $transition = $this->getTransition($transitionId);
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
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function getTransitionsInitialStatusesAction($workflowId, $transitionId)
    {
        return $this->getTransition($transitionId)->getInitialStates();
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
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        return $this->getTransition($transitionId)->getInitialState($initialStatusId);
    }

    /**
     * Creates an initial status of transition id and workflow id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $workflowId   The workflow id
     * @param string                                    $transitionId The transition id
     *
     * @ApiDoc(statusCodes={201, 400, 403, 404, 409})
     * @Http\Post("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses")
     * @View(statusCode=201, serializerGroups={"transitionList", "transition"})
     * @Workflow("manage_status")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function postTransitionsInitialStatusAction(Request $request, $workflowId, $transitionId)
    {
        $transition = $this->getTransition($transitionId);
        if (($initialStatusId = $request->get('initial_status')) === null) {
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
     * @Workflow("manage_status")
     *
     * @throws \Kreta\Component\Core\Exception\ResourceInUseException
     */
    public function deleteTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        $transition = $this->getTransition($transitionId);
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
     * @Workflow()
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getTransitionsEndStatusAction($workflowId, $transitionId)
    {
        return $this->getTransition($transitionId)->getState();
    }

    /**
     * Gets the status transition if exists.
     *
     * @param string $transitionId The transition id
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    protected function getTransition($transitionId)
    {
        return $this->get('kreta_workflow.repository.status_transition')->find($transitionId, false);
    }
}
