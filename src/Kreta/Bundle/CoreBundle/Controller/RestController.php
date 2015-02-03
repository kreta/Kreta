<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Kreta\Component\Core\Repository\EntityRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RestController.
 *
 * @package Kreta\Bundle\CoreBundle\Controller
 */
class RestController extends FOSRestController
{
    /**
     * Gets the project if the current user is granted and if the project exists.
     *
     * @param string $projectId    The project id
     * @param string $projectGrant The project grant, by default view
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected function getProjectIfAllowed($projectId, $projectGrant = 'view')
    {
        return $this->getResourceIfAllowed(
            $this->get('kreta_project.repository.project'), $projectId, $projectGrant
        );
    }

    /**
     * Gets the workflow if the current user is granted and if the workflow exists.
     *
     * @param string $workflowId    The workflow id
     * @param string $workflowGrant The workflow grant, by default view
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected function getWorkflowIfAllowed($workflowId, $workflowGrant = 'view')
    {
        return $this->getResourceIfAllowed(
            $this->get('kreta_workflow.repository.workflow'), $workflowId, $workflowGrant
        );
    }

    /**
     * Gets the resource if the current user is granted and if the resource exists.
     *
     * @param \Kreta\Component\Core\Repository\EntityRepository $repository The repository
     * @param string                                            $id         The id
     * @param string                                            $grant      The grant
     *
     * @return Object
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    private function getResourceIfAllowed(EntityRepository $repository, $id, $grant = 'view')
    {
        $resource = $repository->find($id, false);
        if (!$this->get('security.context')->isGranted($grant, $resource)) {
            throw new AccessDeniedException();
        }

        return $resource;
    }
}
