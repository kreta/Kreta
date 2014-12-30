<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model\Interfaces;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Interface RepositoryInterface
 *
 * @package Kreta\Component\VCS\Model\Interfaces
 */
interface RepositoryInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Sets id.
     *
     * @param string $id
     *
     * @return self
     */
    public function setId($id);

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);
    /**
     * Gets projects associated to the repository
     *
     * @return ProjectInterface[]
     */
    public function getProjects();

    /**
     * Adds project to repository.
     *
     * @param ProjectInterface $project
     *
     * @return mixed
     */
    public function addProject(ProjectInterface $project);

    /**
     * Removes association to project.
     *
     * @param ProjectInterface $project
     *
     * @return self
     */
    public function removeProject(ProjectInterface $project);

    /**
     * Gets provider. For example 'github'
     *
     * @return self
     */
    public function getProvider();

    /**
     * Sets provider
     *
     * @param string $provider
     *
     * @return self
     */
    public function setProvider($provider);

    /**
     * Gets the url that points to the repository in providers page
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set the url that points to the repository in providers page
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url);
}
