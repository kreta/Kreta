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

namespace Kreta\Component\Project\Model;

use Doctrine\Common\Collections\ArrayCollection;
use EasySlugger\Slugger;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class Project.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Project implements ProjectInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The image.
     *
     * @var MediaInterface
     */
    protected $image;

    /**
     * Array that contains all the issues of the project.
     *
     * @var ArrayCollection
     */
    protected $issues;

    /**
     * Array that contains labels.
     *
     * @var ArrayCollection
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
     * @var ArrayCollection
     */
    protected $participants;

    /**
     * Array that contains all the issue priorities of the project.
     *
     * @var ArrayCollection
     */
    protected $issuePriorities;

    /**
     * The organization.
     *
     * @var OrganizationInterface|null
     */
    protected $organization;

    /**
     * The user.
     *
     * @var UserInterface
     */
    protected $creator;

    /**
     * The slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * The workflow.
     *
     * @var WorkflowInterface
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
        $this->issuePriorities = new ArrayCollection();
    }

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
        foreach ($this->labels as $el) {
            if (strtolower($el->getName()) === strtolower($label->getName())) {
                return $this;
            }
        }
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
        $this->setSlug(Slugger::slugify($name));

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
    public function getIssuePriorities()
    {
        return $this->issuePriorities;
    }

    /**
     * {@inheritdoc}
     */
    public function addIssuePriority(IssuePriorityInterface $issuePriority)
    {
        $this->issuePriorities[] = $issuePriority;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeIssuePriority(IssuePriorityInterface $issuePriority)
    {
        $this->issuePriorities->removeElement($issuePriority);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrganization(OrganizationInterface $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreator(UserInterface $creator)
    {
        $this->creator = $creator;

        return $this;
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

    /**
     * Magic method that is useful in Twig templates
     * representing the entity class into string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
