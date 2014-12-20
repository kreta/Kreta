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

/**
 * Class WorkflowController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller
 */
class WorkflowController extends AbstractRestController
{
    public function getWorkflowsAction()
    {
    }

    public function getWorkflowAction($workflowId)
    {
    }

    public function postWorkflowAction()
    {
    }

    public function putWorkflowAction()
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('kreta_workflow.repository.workflow');
    }
}
