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

use Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class StatusTransitionController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
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
            ['status']
        );
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
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
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
        return $this->get('kreta_workflow.repository.status');
    }
}
