<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StatusTransitionController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
 */
class StatusTransitionController extends AbstractRestController
{
    /**
     * Returns transitions of workflow id given.
     *
     * @param string $workflowId The workflow id
     *
     * @ApiDoc(
     *  description = "Returns transitions of workflow id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any workflow with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionsAction($workflowId)
    {
        return $this->createResponse(
            $this->getWorkflowIfAllowed($workflowId)->getStatusTransitions(), ['transitionList']
        );
    }

    /**
     * Returns the transition of workflow id and status transition id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The status transition id
     *
     * @ApiDoc(
     *  description = "Returns the transition of workflow id and status transition id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any workflow with <$id> id",
     *    404 = "Does not exist any transition with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionAction($workflowId, $transitionId)
    {
        return $this->createResponse($this->getTransitionIfAllowed($workflowId, $transitionId), ['transition']);
    }

    /**
     * Deletes the transition of workflow id and transition id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(
     *  description = "Deletes the transition of workflow id and transition id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      204 = "",
     *      403 = {
     *          "Not allowed to access this resource",
     *          "Remove operation has been cancelled, the transition is currently in use"
     *      },
     *      404 = {
     *          "Does not exist any workflow with <$id> id",
     *          "Does not exist any transition with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTransitionAction($workflowId, $transitionId)
    {
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');

        $issues = $this->get('kreta_issue.repository.issue')->findByWorkflow($transition->getWorkflow());
        foreach ($issues as $issue) {
            foreach ($issue->getStatus()->getTransitions() as $retrieveTransition) {
                if ($retrieveTransition->getId() === $transition->getId()) {
                    throw new HttpException(
                        Codes::HTTP_FORBIDDEN,
                        'Remove operation has been cancelled, the transition is currently in use'
                    );
                }
            }
        }

        $this->getRepository()->delete($transition);

        return $this->createResponse('', null, Codes::HTTP_NO_CONTENT);
    }

    /**
     * Returns initial statuses of transition id and workflow id given.
     *
     * @param string $workflowId   The workflow id
     * @param string $transitionId The transition id
     *
     * @ApiDoc(
     *  description = "Returns initial statuses of transition id and workflow id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = {
     *        "Does not exist any workflow with <$id> id",
     *        "Does not exist any transition with <$id> id"
     *    }
     *  }
     * )
     *
     * @Get("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionsInitialStatusesAction($workflowId, $transitionId)
    {
        return $this->createResponse(
            $this->getTransitionIfAllowed($workflowId, $transitionId)->getInitialStates(),
            ['transitionList', 'transition']
        );
    }

    /**
     * Returns the initial status of status initial id, transition id and workflow id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     * @param string $initialStatusId The initial status id
     *
     * @ApiDoc(
     *  description = "Returns the initial status of status initial id, transition id and workflow id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = {
     *        "Does not exist any workflow with <$id> id",
     *        "Does not exist any transition with <$id> id",
     *        "Does not exist any initial status with <$id> id"
     *    }
     *  }
     * )
     *
     * @Get("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses/{initialStatusId}")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        $initialStatuses = $this->getTransitionIfAllowed($workflowId, $transitionId)->getInitialStates();

        foreach ($initialStatuses as $initialStatus) {
            if ($initialStatus->getId() === $initialStatusId) {
                return $this->createResponse($initialStatus, ['transitionList', 'transition']);
            }
        }
        throw new NotFoundHttpException(sprintf('Does not exist any initial status with %s id', $initialStatusId));
    }

    /**
     * Creates an initial status of transition id and workflow id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     *
     * @ApiDoc(
     *  description = "Creates an initial status of transition id and workflow id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = {
     *        "Does not exist any workflow with <$id> id",
     *        "Does not exist any transition with <$id> id"
     *    }
     *  }
     * )
     *
     * @Post("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postTransitionsInitialStatusAction($workflowId, $transitionId)
    {
        if (($initialStatusId = $this->get('request')->get('initial_status')) === null) {
            throw new BadRequestHttpException('The initial status should not be blank');
        }
        $initialStatus = $this->get('kreta_workflow.repository.status')->find($initialStatusId);
        if (!($initialStatus instanceof StatusInterface)) {
            throw new NotFoundHttpException(
                sprintf('Does not exist any initial status with %s id', $initialStatusId)
            );
        }
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');
        $transition->addInitialState($initialStatus);
        $this->getRepository()->save($transition);

        return $this->createResponse($transition->getInitialStates(), ['transitionList', 'transition']);
    }

    /**
     * Deletes the initial status of workflow id, transition id and initial status id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     * @param string $initialStatusId The initial status id
     *
     * @ApiDoc(
     *  description = "Deletes the initial status of workflow id, transition id and initial status id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      204 = "",
     *      403 = {
     *          "Not allowed to access this resource",
     *          "Remove operation has been cancelled, the transition is currently in use"
     *      },
     *      404 = {
     *          "Does not exist any workflow with <$id> id",
     *          "Does not exist any transition with <$id> id",
     *          "Does not exist any initial status with <$id> id"
     *      }
     *  }
     * )
     *
     * @Delete("/workflows/{workflowId}/transitions/{transitionId}/initial-statuses/{initialStatusId}")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTransitionsInitialStatusAction($workflowId, $transitionId, $initialStatusId)
    {
        $transition = $this->getTransitionIfAllowed($workflowId, $transitionId, 'manage_status');

        $issues = $this->get('kreta_issue.repository.issue')->findByWorkflow($transition->getWorkflow());
        foreach ($issues as $issue) {
            foreach ($issue->getStatus()->getTransitions() as $retrieveTransition) {
                if ($retrieveTransition->getId() === $transition->getId()) {
                    throw new HttpException(
                        Codes::HTTP_FORBIDDEN,
                        'Remove operation has been cancelled, the transition is currently in use'
                    );
                }
            }
        }

        $initialStatuses = $transition->getInitialStates();

        foreach ($initialStatuses as $initialStatus) {
            if ($initialStatus->getId() === $initialStatusId) {
                $transition->removeInitialState($initialStatus);
                $this->getRepository()->save($transition);

                return $this->createResponse('', null, Codes::HTTP_NO_CONTENT);
            }
        }
        throw new NotFoundHttpException(sprintf('Does not exist any initial status with %s id', $initialStatusId));
    }

    /**
     * Returns the end status of transition id and workflow id given.
     *
     * @param string $workflowId      The workflow id
     * @param string $transitionId    The transition id
     *
     * @ApiDoc(
     *  description = "Returns the end status of transition id and workflow id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = {
     *        "Does not exist any workflow with <$id> id",
     *        "Does not exist any transition with <$id> id"
     *    }
     *  }
     * )
     *
     * @Get("/workflows/{workflowId}/transitions/{transitionId}/end-status")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionsEndStatusAction($workflowId, $transitionId)
    {
        return $this->createResponse(
            $this->getTransitionIfAllowed($workflowId, $transitionId)->getState(), ['transitionList', 'transition']
        );
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

        return $this->getResourceIfExists($transitionId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_workflow.repository.status_transition');
    }
}
