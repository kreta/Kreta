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
 * Class LabelController.
 *
 * @package Kreta\Bundle\ProjectBundle\Controller
 */
class LabelController extends RestController
{
    /**
     * Returns all the labels of project id given, it admits limit and offset.
     *
     * @param string                               $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Name filter")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"labelList"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface[]
     */
    public function getLabelsAction($projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.label')->findByProject(
            $this->getProjectIfAllowed($projectId),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new label for name given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"label"})
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface
     */
    public function postLabelsAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId, 'create_label');

        return $this->get('kreta_project.form_handler.label')->processForm(
            $this->get('request'), null, ['project' => $project]
        );
    }

    /**
     * Deletes label of project id and label id given.
     *
     * @param string $projectId The project id
     * @param string $labelId   The label id
     *
     * @ApiDoc(statusCodes={204, 403, 404})
     * @View(statusCode=204)
     *
     * @return void
     */
    public function deleteLabelsAction($projectId, $labelId)
    {
        $this->getProjectIfAllowed($projectId, 'delete_label');

        $repository = $this->get('kreta_project.repository.label');
        $label = $repository->find($labelId, false);
        $repository->remove($label);
    }
}
