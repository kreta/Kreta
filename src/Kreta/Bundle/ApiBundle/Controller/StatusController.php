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

use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController;
use Kreta\Bundle\ApiBundle\Exception\ResourceInUseException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class StatusController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
 */
class StatusController extends AbstractRestController
{
    /**
     * Returns all the statuses of workflow id given.
     *
     * @param string $workflowId The workflow id
     *
     * @ApiDoc(
     *  description = "Returns all the statuses of workflow id given",
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
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"statusList"}
     * )
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function getStatusesAction($workflowId)
    {
        return $this->getWorkflowIfAllowed($workflowId)->getStatuses();
    }

    /**
     * Returns the status of id and workflow id given.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     *
     * @ApiDoc(
     *  description = "Returns the status of id and workflow id given",
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
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"status"}
     * )
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getStatusAction($workflowId, $statusId)
    {
        return $this->getStatusIfAllowed($workflowId, $statusId);
    }

    /**
     * Creates new status for name, color and type given.
     *
     * @param string $workflowId The workflow id
     *
     * @ApiDoc(
     *  description = "Creates new status for name, color and type given",
     *  input = "Kreta\Bundle\ApiBundle\Form\Type\StatusType",
     *  output = "Kreta\Component\Workflow\Model\Interfaces\StatusInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    201 = "<data>",
     *    400 = {
     *      "Name should not be blank",
     *      "Color should not be blank",
     *      "Type should not be blank",
     *      "A status with identical name is already exist in this project",
     *      "The type is not valid"
     *    },
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(
     *  statusCode=201,
     *  serializerGroups={"status"}
     * )
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function postStatusesAction($workflowId)
    {
        $workflow = $this->getWorkflowIfAllowed($workflowId, 'manage_status');

        return $this->get('kreta_api.form_handler.status')->processForm(
            $this->get('request'), null, ['workflow' => $workflow]
        );
    }

    /**
     * Updates the status of workflow id and status id given.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     *
     * @ApiDoc(
     *  description = "Updates the status of workflow id and status id given",
     *  input = "Kreta\Bundle\ApiBundle\Form\Type\StatusType",
     *  output = "Kreta\Component\Workflow\Model\Interfaces\StatusInterface",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    200 = "Successfully created",
     *    400 = {
     *      "Name should not be blank",
     *      "Color should not be blank",
     *      "Type should not be blank",
     *      "A status with identical name is already exist in this project",
     *      "The type is not valid"
     *    },
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"status"}
     * )
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function putStatusesAction($workflowId, $statusId)
    {
        $status = $this->getStatusIfAllowed($workflowId, $statusId, 'manage_status');

        return $this->get('kreta_api.form_handler.status')->processForm(
            $this->get('request'), $status, ['method' => 'PUT']
        );
    }

    /**
     * Deletes the status and its associate transitions of workflow id and id given.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     *
     * @ApiDoc(
     *  description = "Deletes the status and its associate transitions of workflow id and id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    204 = "",
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any object with id passed",
     *    409 = "The resource is currently in use"
     *  }
     * )
     *
     * @View(statusCode=204)
     *
     * @return void
     * @throws \Kreta\Bundle\ApiBundle\Exception\ResourceInUseException
     */
    public function deleteStatusesAction($workflowId, $statusId)
    {
        $status = $this->getStatusIfAllowed($workflowId, $statusId, 'manage_status');
        if ($this->get('kreta_issue.repository.issue')->isStatusInUse($status->getWorkflow(), $status)) {
            throw new ResourceInUseException();
        }
        $this->get('kreta_workflow.repository.status')->remove($status);
    }

    /**
     * Gets the status if the current user is granted and if the workflow exists.
     *
     * @param string $workflowId The workflow id
     * @param string $statusId   The status id
     * @param string $grant      The grant, by default 'view'
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    protected function getStatusIfAllowed($workflowId, $statusId, $grant = 'view')
    {
        $this->getWorkflowIfAllowed($workflowId, $grant);

        return $this->get('kreta_workflow.repository.status')->find($statusId, false);
    }
}
