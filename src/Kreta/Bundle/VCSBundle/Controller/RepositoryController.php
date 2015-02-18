<?php

/**
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
use Kreta\Bundle\CoreBundle\Controller\RestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class RepositoryController.
 *
 * @package Kreta\Bundle\VCSBundle\Controller
 */
class RepositoryController extends RestController
{
    /**
     * Returns all repositories of project id given.
     *
     * @param string $projectId The project id
     *
     * @ApiDoc(
     *  description = "Returns all repositories of project id given",
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
     * @Get("/projects/{projectId}/vcs-repositories")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"repositoryList"}
     * )
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface[]
     */
    public function getRepositoriesAction($projectId)
    {
        $project = $this->getProjectIfAllowed($projectId);

        return $this->get('kreta_vcs.repository.repository')->findByProject($project);
    }
}
