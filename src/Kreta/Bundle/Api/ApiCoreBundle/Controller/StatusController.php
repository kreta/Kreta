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
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class StatusController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusController extends ResourceController
{
    /**
     * The name of class.
     *
     * @var string
     */
    protected $class = 'status';

    /**
     * The name of bundle.
     *
     * @var string
     */
    protected $bundle = 'core';

    /**
     * Returns all the statuses of project id given.
     *
     * @ApiDoc(
     *  description = "Returns all the statuses of project id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *    403 = "Not allowed to access this resource",
     *    404 = "Does not exist any project with <$id> id"
     *  }
     * )
     *
     * @param string $id The project id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStatusesAction($id)
    {
        return $this->handleView(
            $this->createView(
                $this->getProjectIfExistsAndIfIsGranted($id)->getStatuses(),
                array('statusList')
            )
        );
    }

    /**
     * Returns the status of id and project id given.
     *
     * @ApiDoc(
     *  description = "Returns the status of id and project id given",
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
     * @param string $projectId The project if
     * @param string $id        The status id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStatusAction($projectId, $id)
    {
        return $this->handleView(
            $this->createView(
                $this->getStatusIfExists($projectId, $id),
                array('status')
            )
        );
    }

    /**
     * Creates new status for name, color and type given.
     * Type is a choice option that its values can be 'initial', 'normal' or 'final'.
     *
     * @ApiDoc(
     *  description = "Creates new status for name, color and type given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType",
     *  output = "Kreta\Component\Core\Model\Interfaces\StatusInterface",
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
     *          "The type is not valid"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = "Does not exist any project with <$id> id"
     *  }
     * )
     *
     * @param string $id The id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postStatusesAction($id)
    {
        $name = $this->get('request')->get('name');
        if (!$name) {
            throw new BadRequestHttpException('Name should not be blank');
        }
        $status = $this->get('kreta_core.factory_status')->create($name);
        $status->setProject($this->getProjectIfExistsAndIfIsGranted($id, 'manage_status'));

        return $this->manageForm(new StatusType(), $status, array('status'));
    }

    /**
     * Updates the status for name, color and type given.
     * Type is a choice option that its values can be 'initial', 'normal' or 'final'.
     *
     * @ApiDoc(
     *  description = "Updates the status for name, color and type given",
     *  input = "Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType",
     *  output = "Kreta\Component\Core\Model\Interfaces\StatusInterface",
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
     *          "The type is not valid"
     *      },
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any status with <$id> id"
     *      }
     *  }
     * )
     *
     * @param string $projectId The project id
     * @param string $id        The id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putStatusesAction($projectId, $id)
    {
        return $this->manageForm(
            new StatusType(), $this->getStatusIfExists($projectId, $id, 'manage_status'), array('status')
        );
    }

    /**
     * Deletes the status and its associate transitions of project id and id given.
     *
     * @param string $projectId The project id
     * @param string $id        The id
     *
     * @ApiDoc(
     *  description = "Deletes the status and its associate transitions of project id and id given",
     *  requirements = {
     *    {
     *      "name"="_format",
     *      "requirement"="json|jsonp",
     *      "description"="Supported formats, by default json"
     *    }
     *  },
     *  statusCodes = {
     *      204 = "Successfully removed",
     *      403 = "Not allowed to access this resource",
     *      404 = {
     *          "Does not exist any project with <$id> id",
     *          "Does not exist any status with <$id> id"
     *      }
     *  }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteStatusesAction($projectId, $id)
    {
        $status = $this->getStatusIfExists($projectId, $id, 'delete');
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($status);
        $manager->flush();

        return $this->handleView($this->createView('The status is successfully removed', null, 204));
    }
}
