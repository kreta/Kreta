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

use FOS\RestBundle\Controller\FOSRestController;
use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RestController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
 */
class RestController extends FOSRestController
{
    /**
     * Checks if user is authenticated returning this, otherwise throws an exception.
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function getUser()
    {
        $user = parent::getUser();
        if (!($user instanceof UserInterface)) {
            throw new AccessDeniedException();
        }

        return $user;
    }

    /**
     * Gets the project if the current user is granted and if the project exists.
     *
     * @param string $projectId    The project id
     * @param string $projectGrant The project grant, by default view
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function getProjectIfAllowed($projectId, $projectGrant = 'view')
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
    public function getWorkflowIfAllowed($workflowId, $workflowGrant = 'view')
    {
        return $this->getResourceIfAllowed(
            $this->get('kreta_workflow.repository.workflow'), $workflowId, $workflowGrant
        );
    }

    /**
     * Gets the workflow if the current user is granted and if the workflow exists.
     *
     * @param \Kreta\Component\Core\Repository\EntityRepository $repository The repository
     * @param string                                            $id         The id
     * @param string                                            $grant      The grant
     *
     * @return mixed
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function getResourceIfAllowed(EntityRepository $repository, $id, $grant = 'view')
    {
        $resource = $repository->find($id, false);
        if (!$this->get('security.context')->isGranted($grant, $resource)) {
            throw new AccessDeniedException();
        }

        return $resource;
    }
}
