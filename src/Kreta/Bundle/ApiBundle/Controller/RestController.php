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
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function getProjectIfAllowed($projectId, $projectGrant = 'view')
    {
        $project = $this->get('kreta_project.repository.project')->find($projectId, false);
        if (!$this->get('security.context')->isGranted($projectGrant, $project)) {
            throw new AccessDeniedException();
        }

        return $project;
    }

    /**
     * Gets the workflow if the current user is granted and if the workflow exists.
     *
     * @param string $workflowId    The workflow id
     * @param string $workflowGrant The workflow grant, by default view
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    protected function getWorkflowIfAllowed($workflowId, $workflowGrant = 'view')
    {
        $workflow = $this->get('kreta_workflow.repository.workflow')->find($workflowId, false);
        if (!$this->get('security.context')->isGranted($workflowGrant, $workflow)) {
            throw new AccessDeniedException();
        }

        return $workflow;
    }
}
