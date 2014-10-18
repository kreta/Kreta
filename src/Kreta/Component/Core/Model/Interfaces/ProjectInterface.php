<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Model\Interfaces;

/**
 * Interface Project.
 *
 * @package Kreta\Component\Core\Model\Interfaces
 */
interface ProjectInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets issues.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function getIssues();

    /**
     * Adds issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return $this self Object
     */
    public function addIssue(IssueInterface $issue);

    /**
     * Removes issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return $this self Object
     */
    public function removeIssue(IssueInterface $issue);

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
     * Gets participants.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\UserInterface[]
     */
    public function getParticipants();

    /**
     * Adds participant.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $participant The user object
     *
     * @return $this self Object
     */
    public function addParticipant(UserInterface $participant);

    /**
     * Removes participant.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $participant The user object
     *
     * @return $this self Object
     */
    public function removeParticipant(UserInterface $participant);

    /**
     * Gets project roles.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface[]
     */
    public function getProjectRoles();

    /**
     * Adds project role.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface $projectRole The project role
     *
     * @return $this self Object
     */
    public function addProjectRole(ProjectRoleInterface $projectRole);

    /**
     * Removes project role.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface $projectRole The project role
     *
     * @return $this self Object
     */
    public function removeProjectRole(ProjectRoleInterface $projectRole);

    /**
     * Gets short name.
     *
     * @return string
     */
    public function getShortName();

    /**
     * Sets short name.
     *
     * @param string $shortName The short name
     *
     * @return $this self Object
     */
    public function setShortName($shortName);

    /**
     * Gets role of user given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user The user
     *
     * @return string
     */
    public function getUserRole(UserInterface $user);
}
