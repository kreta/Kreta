<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\OrganizationBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Organization;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Participant controller class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantController extends Controller
{
    /**
     * Returns all the participants of organization id given, it admits limit and offset.
     *
     * @param Request      $request        The request
     * @param string       $organizationId The organization id
     * @param ParamFetcher $paramFetcher   The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of participants to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="User email filter")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"organizationParticipantList"})
     * @Organization()
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\ParticipantInterface[]
     */
    public function getParticipantsAction(Request $request, $organizationId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_organization.repository.participant')->findByOrganization(
            $request->get('organization'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new participant for role and user given.
     *
     * @param Request $request        The request
     * @param string  $organizationId The organization id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"organizationParticipant"})
     * @Organization("add_participant")
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\ParticipantInterface
     */
    public function postParticipantsAction(Request $request, $organizationId)
    {
        $users = $this->get('kreta_user.repository.user')->findAll();

        return $this->get('kreta_organization.form_handler.participant')->processForm(
            $request, null, ['organization' => $request->get('organization'), 'users' => $users]
        );
    }

    /**
     * Deletes participant of organization id and user id given.
     *
     * @param string $organizationId The organization id
     * @param string $userId         The user id
     *
     * @ApiDoc(statusCodes={204, 403, 404})
     * @View(statusCode=204)
     * @Organization("delete_participant")
     */
    public function deleteParticipantsAction($organizationId, $userId)
    {
        $repository = $this->get('kreta_organization.repository.participant');
        $participant = $repository->findOneBy(['organization' => $organizationId, 'user' => $userId], false);
        $repository->remove($participant);
    }
}
