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
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;

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
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of participants to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="User email filter")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"participantList"})
     *
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
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"participant"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface
     */
    public function postParticipantsAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId, 'add_participant');
        $users = $this->get('kreta_user.repository.user')->findAll();

        return $this->get('kreta_project.form_handler.participant')->processForm(
            $this->get('request'), null, ['project' => $project, 'users' => $users]
        );
    }

    /**
     * Deletes participant of project id and user id given.
     *
     * @param string $projectId The project id
     * @param string $userId    The user id
     *
     * @ApiDoc(statusCodes={204, 403, 404})
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
