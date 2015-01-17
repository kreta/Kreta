<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class Repository.
 *
 * @package Kreta\Component\VCS\Model
 */
class Repository implements RepositoryInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Array which contains projects.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    protected $projects;

    /**
     * The provider.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $provider;

    /**
     * The url.
     *
     * @var string
     */
    protected $url;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject(ProjectInterface $project)
    {
        $this->projects->add($project);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProject(ProjectInterface $project)
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
