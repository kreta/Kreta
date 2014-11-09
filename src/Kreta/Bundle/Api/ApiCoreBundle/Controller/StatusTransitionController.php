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

use Kreta\Bundle\Api\ApiCoreBundle\Controller\Base\ResourceController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StatusTransitionController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusTransitionController extends ResourceController
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
        return $this->handleView(
            $this->createView(
                $this->getStatusIfExists($projectId, $statusId)->getTransitions(),
                array('status')
            )
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
     *          "Name should not be blank",
     *          "Color should not be blank",
     *          "Type should not be blank",
     *          "This status is already exist in this project",
     *          "The type is not valid",
     *          "To status name should not be blank"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any status with <$id> id",
     *          "Does not exist any status with <$toStatusName> name"
     *      }
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
        /** @var \Kreta\Component\Core\Model\Interfaces\StatusInterface $status */
        $status = $this->getStatusIfExists($projectId, $statusId, 'manage_status');
        $toStatusName = $this->get('request')->get('to');
        if (!$toStatusName) {
            throw new BadRequestHttpException('To status name should not be blank');
        }
        $toStatus = $this->get('kreta_core.repository_status')->findOneByName($toStatusName);
        if (!$toStatus) {
            throw new NotFoundHttpException('Does not exist any status with ' . $toStatusName . ' name');
        }
        $status->addStatusTransition($toStatus);

        return $this->handleView($this->createView($status->getTransitions(), array('status')));
    }

//    /**
//     * Updates the status for name, color and type given.
//     * Type is a choice option that its values can be 'initial', 'normal' or 'final'.
//     *
//     * @ApiDoc(
//     *  description = "Updates the status for name, color and type given",
//     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType",
//     *  output = "Kreta\Component\Core\Model\Interfaces\StatusInterface",
//     *  requirements = {
//     *    {
//     *      "name"="_format",
//     *      "requirement"="json|jsonp",
//     *      "description"="Supported formats, by default json"
//     *    }
//     *  },
//     *  statusCodes = {
//     *      200 = "Successfully created",
//     *      400 = {
//     *          "Name should not be blank",
//     *          "Color should not be blank",
//     *          "Type should not be blank",
//     *          "This status is already exist in this project",
//     *          "The type is not valid"
//     *      },
//     *      403 = "Not allowed to access this resource",
//     *      404 = {
//     *          "Does not exist any project with <$id> id",
//     *          "Does not exist any status with <$id> id"
//     *      }
//     *  }
//     * )
//     *
//     * @param string $projectId The project id
//     * @param string $statusId  The status id
//     * @param string $id        The id
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function deleteTransitionAction($projectId, $statusId, $id)
//    {
//        return $this->manageForm(
//            new StatusType(), $this->getStatusIfExists($projectId, $id, 'manage_status'), array('status')
//        );
//    }
}
