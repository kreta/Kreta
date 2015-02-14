<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class Project.
 *
 * @package Kreta\Component\Project\Model
 */
class Project extends AbstractModel implements ProjectInterface
{
    /**
     * The image.
     *
     * @var \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    protected $image;

    /**
     * Array that contains all the issues of the project.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $issues;

    /**
     * Array that contains labels.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $labels;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Array that contains all the roles of the project.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $participants;

    /**
     * The short name.
     *
     * @var string
     */
    protected $shortName;

    /**
     * The workflow.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected $workflow;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->labels = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(MediaInterface $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * {@inheritdoc}
     */
    public function addIssue(IssueInterface $issue)
    {
        $this->issues[] = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeIssue(IssueInterface $issue)
    {
        $this->issues->removeElement($issue);

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

        if ($this->shortName === null) {
            $this->shortName = substr($this->name, 0, 26) . '...';
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * {@inheritdoc}
     */
    public function addParticipant(ParticipantInterface $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeParticipant(ParticipantInterface $participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * {@inheritdoc}
     */
    public function setShortName($shortName)
    {
        if (strlen($shortName) > 26) {
            $this->shortName = substr($shortName, 0, 26) . '...';

            return $this;
        }

        $this->shortName = $shortName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserRole(UserInterface $user)
    {
        foreach ($this->participants as $participant) {
            if ($participant->getUser()->getId() === $user->getId()) {
                return $participant->getRole();
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkflow(WorkflowInterface $workflow)
    {
        $this->workflow = $workflow;

        return $this;
    }
}
