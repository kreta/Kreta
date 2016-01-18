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

namespace Kreta\Component\Issue\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Model\Interfaces\ResolutionInterface;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;

/**
 * Class Issue.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Issue extends AbstractModel implements IssueInterface
{
    /**
     * The assignee.
     *
     * @var \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    protected $assignee;

    /**
     * Child issues.
     *
     * @var \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    protected $children;

    /**
     * Created at.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * The description.
     *
     * @var string
     */
    protected $description;

    /**
     * Array that contains labels.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $labels;

    /**
     * The auto increment numeric id.
     *
     * @var int
     */
    protected $numericId;

    /**
     * Parent issue.
     *
     * @var \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    protected $parent;

    /**
     * The priority.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface
     */
    protected $priority;

    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * The resolution.
     *
     * @var \Kreta\Component\Issue\Model\Interfaces\ResolutionInterface
     */
    protected $resolution;

    /**
     * The reporter.
     *
     * @var \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    protected $reporter;

    /**
     * The status.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    protected $status;

    /**
     * The title.
     *
     * @var string
     */
    protected $title;

    /**
     * Array that contains the watchers.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $watchers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->labels = new ArrayCollection();
        $this->watchers = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * {@inheritdoc}
     */
    public function setAssignee(UserInterface $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAssignee(UserInterface $user)
    {
        return $this->assignee->getId() === $user->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function addChildren(IssueInterface $issue)
    {
        $this->children[] = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChildren(IssueInterface $issue)
    {
        $this->children->removeElement($issue);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFiniteState()
    {
        return $this->status->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setFiniteState($state)
    {
        $statuses = $this->project->getWorkflow()->getStatuses();

        foreach ($statuses as $status) {
            if ($state === $status->getName()) {
                $this->status = $status;
                break;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * {@inheritdoc}
     */
    public function addLabel(LabelInterface $label)
    {
        $this->labels[] = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeLabel(LabelInterface $label)
    {
        $this->labels->removeElement($label);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumericId()
    {
        return $this->numericId;
    }

    /**
     * {@inheritdoc}
     */
    public function setNumericId($numericId)
    {
        $this->numericId = $numericId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(IssueInterface $issue)
    {
        $this->parent = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function setPriority(IssuePriorityInterface $priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * {@inheritdoc}
     */
    public function setReporter(UserInterface $reporter)
    {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isReporter(UserInterface $user)
    {
        return $this->reporter->getId() === $user->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * {@inheritdoc}
     */
    public function setResolution(ResolutionInterface $resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        !$status instanceof StatusInterface
            ? $this->setFiniteState($status)
            : $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWatchers()
    {
        return $this->watchers;
    }

    /**
     * {@inheritdoc}
     */
    public function addWatcher(UserInterface $watcher)
    {
        $this->watchers[] = $watcher;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeWatcher(UserInterface $watcher)
    {
        $this->watchers->removeElement($watcher);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isParticipant(UserInterface $user)
    {
        foreach ($this->project->getParticipants() as $participant) {
            if ($user->getId() === $participant->getUser()->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function generateNumericId()
    {
        if (!$this->numericId) {
            $this->numericId = count($this->project->getIssues()) + 1;
        }
    }
}
