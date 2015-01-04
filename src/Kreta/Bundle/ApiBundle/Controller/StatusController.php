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
use Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any workflow with <$id> id"
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStatusesAction($workflowId)
    {
        return $this->createResponse($this->getWorkflowIfAllowed($workflowId)->getStatuses(), ['statusList']);
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
     *    403 = "Not allowed to access this resource",
     *    404 = {
     *      "Does not exist any workflow with <$id> id",
     *      "Does not exist any status with <$id> id"
     *    }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStatusAction($workflowId, $statusId)
    {
        return $this->createResponse($this->getStatusIfAllowed($workflowId, $statusId), ['status']);
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
     *      201 = "Successfully created",
     *      400 = {
     *          "Name should not be blank",
     *          "Color should not be blank",
     *          "Type should not be blank",
     *          "A status with identical name is already exist in this project",
     *          "The type is not valid"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any workflow with <$id> id"
     *  }
     * )
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postStatusesAction($workflowId)
    {
        $name = $this->get('request')->get('name');
        if (!$name) {
            throw new BadRequestHttpException('Name should not be blank');
        }
        $status = $this->get('kreta_workflow.factory.status')->create($name);
        $status->setWorkflow($this->getWorkflowIfAllowed($workflowId, 'manage_status'));

        return $this->post(
            $this->get('kreta_api.form_handler.status'),
            $status,
            ['status']
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
     *      200 = "Successfully created",
     *      400 = {
     *          "Name should not be blank",
     *          "Color should not be blank",
     *          "Type should not be blank",
     *          "A status with identical name is already exist in this project",
     *          "The type is not valid"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any workflow with <$id> id",
     *          "Does not exist any status with <$id> id"
     *      }
     *  }
     * )
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putStatusesAction($workflowId, $statusId)
    {
        return $this->put(
            $this->get('kreta_api.form_handler.status'),
            $this->getStatusIfAllowed($workflowId, $statusId, 'manage_status'),
            ['status']
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
     *      204 = "",
     *      403 = {
     *          "Not allowed to access this resource",
     *          "Remove operation has been cancelled, the status is currently in use"
     *      },
     *      404 = {
     *          "Does not exist any workflow with <$id> id",
     *          "Does not exist any status with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteStatusesAction($workflowId, $statusId)
    {
        $status = $this->getStatusIfAllowed($workflowId, $statusId, 'manage_status');

        $issues = $this->get('kreta_issue.repository.issue')->findByWorkflow($status->getWorkflow());
        foreach ($issues as $issue) {
            if ($issue->getStatus()->getId() === $status->getId()) {
                throw new HttpException(
                    Codes::HTTP_FORBIDDEN,
                    'Remove operation has been cancelled, the status is currently in use'
                );
            }
        }

        $this->getRepository()->remove($status);

        return $this->createResponse('', null, Codes::HTTP_NO_CONTENT);
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

        return $this->getResourceIfExists($statusId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_workflow.repository.status');
    }
}
