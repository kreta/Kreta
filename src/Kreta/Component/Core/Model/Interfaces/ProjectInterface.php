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
     * Gets project roles.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ParticipantInterface[]
     */
    public function getParticipants();

    /**
     * Adds project role.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ParticipantInterface $participant The project role
     *
     * @return $this self Object
     */
    public function addParticipant(ParticipantInterface $participant);

    /**
     * Removes project role.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ParticipantInterface $participant The project role
     *
     * @return $this self Object
     */
    public function removeParticipant(ParticipantInterface $participant);

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
     * Gets statuses.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    public function getStatuses();

    /**
     * Adds status.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     */
    public function addStatus(StatusInterface $status);

    /**
     * Removes status.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     */
    public function removeStatus(StatusInterface $status);

    /**
     * Gets role of user given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user The user
     *
     * @return string
     */
    public function getUserRole(UserInterface $user);
}
