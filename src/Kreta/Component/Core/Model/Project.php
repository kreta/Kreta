<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class Project.
 *
 * @package Kreta\Component\Core\Model
 */
class Project extends AbstractModel implements ProjectInterface
{
    /**
     * Array that contains issues.
     */
    protected $issues;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Array that contains users.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $participants;

    /**
     * Array that contains all the roles of the project.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $projectRoles;

    /**
     * The short name.
     *
     * @var string
     */
    protected $shortName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->projectRoles = new ArrayCollection();
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
    public function addParticipant(UserInterface $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeParticipant(UserInterface $participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectRoles()
    {
        return $this->projectRoles;
    }

    /**
     * {@inheritdoc}
     */
    public function addProjectRole(ProjectRoleInterface $projectRole)
    {
        $this->projectRoles[] = $projectRole;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProjectRole(ProjectRoleInterface $projectRole)
    {
        $this->projectRoles->removeElement($projectRole);

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
        foreach ($this->projectRoles as $projectRole) {
            if ($projectRole->getUser()->getId() === $user->getId()) {
                return $projectRole->getRole();
            }
        }

        return null;
    }
}
