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

namespace Kreta\Component\Project\Model\Interfaces;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Interface Project.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
     * Gets labels.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\LabelInterface[]
     */
    public function getLabels();

    /**
     * Adds the labels.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\LabelInterface $label The label
     *
     * @return $this self Object
     */
    public function addLabel(LabelInterface $label);

    /**
     * Removes the label.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\LabelInterface $label The label
     *
     * @return $this self Object
     */
    public function removeLabel(LabelInterface $label);

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
     * Gets project issue priorities.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface[]
     */
    public function getIssuePriorities();

    /**
     * Adds project issue priority.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface $issuePriority The issue priority
     *
     * @return $this self Object
     */
    public function addIssuePriority(IssuePriorityInterface $issuePriority);

    /**
     * Removes project issue priority.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface $issuePriority The issue priority
     *
     * @return $this self Object
     */
    public function removeIssuePriority(IssuePriorityInterface $issuePriority);

    /**
     * Gets organization.
     *
     * @return OrganizationInterface|null
     */
    public function getOrganization();

    /**
     * Sets organization.
     *
     * @param OrganizationInterface|null $organization The organization
     *
     * @return $this self Object
     */
    public function setOrganization(OrganizationInterface $organization = null);

    /**
     * Gets slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Sets slug.
     *
     * @param string $slug The slug
     *
     * @return $this self Object
     */
    public function setSlug($slug);

    /**
     * Gets role of user given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user The user
     *
     * @return string
     */
    public function getUserRole(UserInterface $user);

    /**
     * Gets the creator.
     *
     * @return UserInterface
     */
    public function getCreator();

    /**
     * Gets role of user given.
     *
     * @param UserInterface $creator The creator
     *
     * @return $this self Object
     */
    public function setCreator(UserInterface $creator);

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
