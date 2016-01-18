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

namespace Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Project;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LabelController.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LabelController extends Controller
{
    /**
     * Returns all the labels of project id given, it admits limit and offset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request      The request
     * @param string                                    $projectId    The project id
     * @param \FOS\RestBundle\Request\ParamFetcher      $paramFetcher The param fetcher
     *
     * @QueryParam(name="limit", requirements="\d+", default="9999", description="Amount of projects to be returned")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset in pages")
     * @QueryParam(name="q", requirements="(.*)", strict=true, nullable=true, description="Name filter")
     *
     * @ApiDoc(resource=true, statusCodes={200, 403, 404})
     * @View(statusCode=200, serializerGroups={"labelList"})
     * @Project()
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface[]
     */
    public function getLabelsAction(Request $request, $projectId, ParamFetcher $paramFetcher)
    {
        return $this->get('kreta_project.repository.label')->findByProject(
            $request->get('project'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset'),
            $paramFetcher->get('q')
        );
    }

    /**
     * Creates new label for name given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     * @param string                                    $projectId The project id
     *
     * @ApiDoc(statusCodes={201, 400})
     * @View(statusCode=201, serializerGroups={"label"})
     * @Project("create_label")
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface
     */
    public function postLabelsAction(Request $request, $projectId)
    {
        return $this->get('kreta_project.form_handler.label')->processForm(
            $request, null, ['project' => $request->get('project')]
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
     * @Project("delete_label")
     */
    public function deleteLabelsAction($projectId, $labelId)
    {
        $repository = $this->get('kreta_project.repository.label');
        $label = $repository->find($labelId, false);
        $repository->remove($label);
    }
}
