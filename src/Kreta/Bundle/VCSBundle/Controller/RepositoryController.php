<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Kreta\Component\Core\Annotation\ResourceIfAllowed as Project;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RepositoryController.
 *
 * @package Kreta\Bundle\VCSBundle\Controller
 */
class RepositoryController extends Controller
{
    /**
     * Returns all repositories of project id given.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   The request
     * @param string                                    $projectId The project id
     *
     * @ApiDoc(resource = true, statusCodes = {200, 403, 404})
     * @Get("/projects/{projectId}/vcs-repositories")
     * @View(statusCode=200, serializerGroups={"repositoryList"})
     * @Project()
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface[]
     */
    public function getRepositoriesAction(Request $request, $projectId)
    {
        return $this->get('kreta_vcs.repository.repository')->findByProject($request->get('project'));
    }
}
