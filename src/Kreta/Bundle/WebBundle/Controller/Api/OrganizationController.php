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

namespace Kreta\Bundle\WebBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use Kreta\Bundle\OrganizationBundle\Security\Authorization\Voter\OrganizationVoter;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\SimpleApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Organization private api controller class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationController extends Controller
{
    /**
     * Returns the organization for given slug.
     *
     * @param string $organizationSlug The slug of organization
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Rest\View(statusCode=200, serializerGroups={"organization"})
     * @Rest\Get("/organizations/{organizationSlug}")
     *
     * @return OrganizationInterface
     */
    public function getOrganizationAction($organizationSlug)
    {
        $organization = $this->get('kreta_organization.repository.organization')->findOneBy(
            ['slug' => $organizationSlug], false
        );
        if (!$this->get('security.authorization_checker')->isGranted(OrganizationVoter::VIEW, $organization)) {
            throw new AccessDeniedException();
        }

        return $organization;
    }

    /**
     * Returns the projects for given organization slug.
     *
     * @param string $organizationSlug The slug of organization
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Rest\View(statusCode=200, serializerGroups={"projectList"})
     * @Rest\Get("/organizations/{organizationSlug}/projects")
     *
     * @return ProjectInterface[]
     */
    public function getOrganizationProjectsAction($organizationSlug)
    {
        $organization = $this->get('kreta_organization.repository.organization')->findOneBy(
            ['slug' => $organizationSlug], false
        );
        if (!$this->get('security.authorization_checker')->isGranted(OrganizationVoter::VIEW, $organization)) {
            throw new AccessDeniedException();
        }

        return $organization->getProjects();
    }

    /**
     * Returns the project of given project slug and organization slug.
     *
     * @param string $organizationSlug The slug of organization
     * @param string $projectSlug      The slug of project
     *
     * @ApiDoc(statusCodes={200, 403, 404})
     * @Rest\View(statusCode=200, serializerGroups={"project"})
     * @Rest\Get("/organizations/{organizationSlug}/projects/{projectSlug}")
     *
     * @return ProjectInterface
     */
    public function getOrganizationProjectAction($organizationSlug, $projectSlug)
    {
        $project = $this->get('kreta_project.repository.project')->findOneBy(
            ['o.slug' => $organizationSlug, 'slug' => $projectSlug], false
        );
        if (!$this->get('security.authorization_checker')->isGranted(OrganizationVoter::VIEW, $project)) {
            throw new AccessDeniedException();
        }

        return $project;
    }
}
