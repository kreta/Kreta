<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Model\Interfaces;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Interface Project.
 *
 * @package Kreta\Component\Project\Model\Interfaces
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
     * Gets image.
     *
     * @return \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    public function getImage();

    /**
     * Sets image.
     *
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface $image The image
     *
     * @return $this self Object
     */
    public function setImage(MediaInterface $image);

    /**
     * Gets issues.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getIssues();

    /**
     * Adds issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return $this self Object
     */
    public function addIssue(IssueInterface $issue);

    /**
     * Removes issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
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
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[]
     */
    public function getParticipants();

    /**
     * Adds project role.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ParticipantInterface $participant The project role
     *
     * @return $this self Object
     */
    public function addParticipant(ParticipantInterface $participant);

    /**
     * Removes project role.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ParticipantInterface $participant The project role
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
     * Gets role of user given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user The user
     *
     * @return string
     */
    public function getUserRole(UserInterface $user);

    /**
     * Gets workflow.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function getWorkflow();

    /**
     * Sets workflow.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return $this self Object
     */
    public function setWorkflow(WorkflowInterface $workflow);
}
