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
 * Class BranchController.
 *
 * @package Kreta\Bundle\VCSBundle\Controller
 */
class BranchController extends RestController
{
    /**
     * Returns all branches of project id and issue id given.
     *
     * @param string $issueId The issue id
     *
     * @ApiDoc(
     *  description = "Returns all branches of issue id given",
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
     * @Get("/issues/{issueId}/vcs-branches")
     *
     * @View(
     *  statusCode=200,
     *  serializerGroups={"branchList"}
     * )
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface[]
     */
    public function getBranchesAction($issueId)
    {
        return $this->get('kreta_vcs.repository.branch')->findByIssue($this->getIssueIfAllowed($issueId));
    }
}
