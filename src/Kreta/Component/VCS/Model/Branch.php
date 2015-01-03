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

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class Branch
 *
 * @package Kreta\Component\VCS\Model
 */
class Branch implements BranchInterface
{
    protected $id;

    protected $name;

    /** @var RepositoryInterface $repository */
    protected $repository;

    protected $issuesRelated;

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
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssuesRelated()
    {
        return $this->issuesRelated;
    }

    /**
     * {@inheritdoc}
     */
    public function setIssuesRelated($issuesRelated)
    {
        $this->issuesRelated = $issuesRelated;

        return $this;
    }
}
