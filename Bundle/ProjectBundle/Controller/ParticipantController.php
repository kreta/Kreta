<?php

/*
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
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Project;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ParticipantController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class ParticipantController extends Controller
{
    /**
     * Returns all the participants of project id given, it admits limit and offset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher      $paramFetcher The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of participants to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="User email filter")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"participantList"})
     * @Project()
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[]
     */
    public function getParticipantsAction(Request $request, $projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.participant')->findByProject(
            $request->get('project'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new participant for role and user given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     * @param string                                    $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"participant"})
     * @Project("add_participant")
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface
     */
    public function postParticipantsAction(Request $request, $projectId)
    {
        $users = $this->get('kreta_user.repository.user')->findAll();

        return $this->get('kreta_project.form_handler.participant')->processForm(
            $request, null, ['project' => $request->get('project'), 'users' => $users]
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
     * @Project("delete_participant")
     *
     * @return void
     */
    public function deleteParticipantsAction($projectId, $userId)
    {
        $repository = $this->get('kreta_project.repository.participant');
        $participant = $repository->findOneBy(['project' => $projectId, 'user' => $userId], false);
        $repository->remove($participant);
    }
}
