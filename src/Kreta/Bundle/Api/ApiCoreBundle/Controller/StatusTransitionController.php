<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Controller;

use Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StatusTransitionController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusTransitionController extends AbstractRestController
{
    /**
     * Returns transitions of status id and project id given.
     *
     * @ApiDoc(
     *  description = "Returns transitions of status id and project id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any project with <$id> id",
     *    404 = "Does not exist any status with <$id> id"
     *  }
     * )
     *
     * @param string $projectId The project id
     * @param string $statusId  The status id
     *
     * @internal param string $id The status id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTransitionsAction($projectId, $statusId)
    {
        return $this->createResponse(
            $this->getStatusIfAllowed($projectId, $statusId)->getTransitions(),
            array('status')
        );
    }

    /**
     * Creates new transition for project and status given.
     *
     * @ApiDoc(
     *  description = "Creates new transition for project and status given",
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
     *          "To status name should not be blank",
     *          "From status and to status are equals",
     *          "From status and to status are equals",
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any status with <$id> id",
     *          "Does not exist any status with <$toStatusName> name"
     *      },
     *      409 = "The <$toStatusName> transition is already exist"
     *  }
     * )
     *
     * @param string $projectId The project id
     * @param string $statusId  The status id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postTransitionsAction($projectId, $statusId)
    {
        $status = $this->getStatusIfAllowed($projectId, $statusId, 'manage_status');
        $toStatusName = $this->getRequest()->get('to');
        if (!$toStatusName) {
            throw new BadRequestHttpException('To status name should not be blank');
        }
        $toStatus = $this->getRepository()->findOneByNameAndProjectId($toStatusName, $projectId);
        if (!$toStatus) {
            throw new NotFoundHttpException('Does not exist any status with ' . $toStatusName . ' name');
        }
        if ($toStatus->getId() === $status->getId()) {
            throw new BadRequestHttpException('From status and to status are equals');
        }
        $transitions = $status->getTransitions();
        foreach ($transitions as $transition) {
            if ($transition->getId() === $toStatus->getId()) {
                throw new BadRequestHttpException('The ' . $toStatus->getName() . ' transition is already exist');
            }
        }

        $status->addStatusTransition($toStatus);
        $this->getRepository()->save($status);

        return $this->createResponse($status->getTransitions(), array('status'));
    }

    /**
     * Deletes the transition of project and status, with transition id given.
     *
     * @ApiDoc(
     *  description = "Deletes the transition of project and status, with transition id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      204 = "",
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any status with <$id> id",
     *          "Does not exist any transition with <$id> id"
     *      }
     *  }
     * )
     *
     * @param string $projectId The project id
     * @param string $statusId  The status id
     * @param string $id        The transition id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTransitionsAction($projectId, $statusId, $id)
    {
        $status = $this->getStatusIfAllowed($projectId, $statusId, 'manage_status');
        $transitions = $status->getTransitions();
        foreach ($transitions as $transition) {
            if ($transition->getId() === $id) {
                $status->removeStatusTransition($transition);
                $this->getRepository()->save($status);

                return $this->createResponse('', null, 204);
            }
        }

        return $this->createResponse('Does not exist any transition with ' . $id . ' id', null, 404);
    }

    /**
     * Gets the status if the current user is granted and if the project exists.
     *
     * @param string $projectId The project id
     * @param string $id        The id
     * @param string $grant     The grant, by default 'view'
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface
     */
    protected function getStatusIfAllowed($projectId, $id, $grant = 'view')
    {
        $this->getProjectIfAllowed($projectId, $grant);

        return $this->getResourceIfExists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_core.repository_status');
    }
}
