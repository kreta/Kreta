<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ParticipantController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class ParticipantController extends RestController
{
    /**
     * Returns all the participants of project id given, it admits limit and offset.
     *
     * @param string                               $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="User email filter")
     *
     * @ApiDoc(
     *  description = "Returns all the participants of project id given, it admits limit and offset",
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
     *  serializerGroups={"participantList"}
     * )
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[]
     */
    public function getParticipantsAction($projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.participant')->findByProject(
            $this->getProjectIfAllowed($projectId),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new participant for role and user given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(
     *  description = "Creates new participant for name given",
     *  input = "Kreta\Bundle\ProjectBundle\Form\Type\Api\ParticipantType",
     *  output = "Kreta\Component\Project\Model\Interfaces\ParticipantInterface",
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
     *      "User should not be blank",
     *      "Role should not be blank",
     *      "This participant is already exists in this project",
     *    }
     *  }
     * )
     *
     * @View(
     *  statusCode=201,
     *  serializerGroups={"participant"}
     * )
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface
     */
    public function postParticipantsAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId, 'add_participant');

        return $this->get('kreta_project.form_handler.api.participant')->processForm(
            $this->get('request'), null, ['project' => $project]
        );
    }

    /**
     * Deletes participant of project id and participant id given.
     *
     * @param string $projectId The project id
     * @param string $userId    The user id
     *
     * @ApiDoc(
     *  description = "Deletes participant of project id and participant id given",
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
     *    404 = "Does not exist any object with id passed"
     *  }
     * )
     *
     * @View(statusCode=204)
     *
     * @return void
     */
    public function deleteParticipantsAction($projectId, $userId)
    {
        $this->getProjectIfAllowed($projectId, 'delete_participant');

        $repository = $this->get('kreta_project.repository.participant');
        $participant = $repository->findOneBy(['project' => $projectId, 'user' => $userId], false);
        $repository->remove($participant);
    }
}
