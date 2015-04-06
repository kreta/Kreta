<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Comment\Model\Interfaces;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Interface CommentInterface.
 *
 * @package Kreta\Component\Comment\Model\Interfaces
 */
interface CommentInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets created at.
     *
     * @param \DateTime $createdAt The created at
     *
     * @return $this self Object
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets description.
     *
     * @param string $description The description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * Gets issue.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getIssue();

    /**
     * Sets issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return $this self Object
     */
    public function setIssue(IssueInterface $issue);

    /**
     * Gets updated at.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Sets updated at.
     *
     * @param \DateTime $updatedAt The updated at
     *
     * @return $this self Object
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Gets written by.
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getWrittenBy();

    /**
     * Sets written by.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $writtenBy The written by
     *
     * @return $this self Object
     */
    public function setWrittenBy(UserInterface $writtenBy);
}
