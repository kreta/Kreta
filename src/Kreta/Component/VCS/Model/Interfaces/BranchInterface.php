<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model\Interfaces;

/**
 * Interface BranchInterface.
 *
 * @package Kreta\Component\VCS\Model\Interfaces
 */
interface BranchInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Gets repository.
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface
     */
    public function getRepository();

    /**
     * Sets repository.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface $repository The repository
     *
     * @return $this self Object
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * Gets issues related.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getIssuesRelated();

    /**
     * Sets issues related.
     *
     * @param array $issuesRelated The issuesRelated to be set
     *
     * @return $this self Object
     */
    public function setIssuesRelated($issuesRelated);

    /**
     * Gets url pointing the branch in the providers page.
     *
     * @return string
     */
    public function getUrl();
}
