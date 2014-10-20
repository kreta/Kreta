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
use FOS\UserBundle\Model\User as BaseUser;
use Kreta\Component\Core\Model\Interfaces\CommentInterface;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class User.
 *
 * @package Kreta\Component\Core\Model
 */
class User extends BaseUser implements UserInterface
{
    /**
     * Array that contains assigned issues.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $assignedIssues;

    /**
     * The Bitbucket access token.
     *
     * @var string
     */
    protected $bitbucketAccessToken;

    /**
     * The Bitbucket id.
     *
     * @var string
     */
    protected $bitbucketId;

    /**
     * Created at.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Array that contains comments.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $comments;

    /**
     * The first name.
     *
     * @var string
     */
    protected $firstName;

    /**
     * The GitHub access token.
     *
     * @var string
     */
    protected $githubAccessToken;

    /**
     * The GitHub id.
     *
     * @var string
     */
    protected $githubId;

    /**
     * The last name.
     *
     * @var string
     */
    protected $lastName;

    /**
     * Array that contains all the roles of the user.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $participants;

    /**
     * Array that contains reported issues.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $reportedIssues;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->assignedIssues = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->participants = new ArrayCollection();
        $this->reportedIssues = new ArrayCollection();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignedIssues()
    {
        return $this->assignedIssues;
    }

    /**
     * {@inheritdoc}
     */
    public function addAssignedIssue(IssueInterface $issue)
    {
        $this->assignedIssues[] = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssignedIssue(IssueInterface $issue)
    {
        $this->assignedIssues->removeElement($issue);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBitbucketAccessToken()
    {
        return $this->bitbucketAccessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setBitbucketAccessToken($bitbucketAccessToken)
    {
        $this->bitbucketAccessToken = $bitbucketAccessToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBitbucketId()
    {
        return $this->bitbucketId;
    }

    /**
     * {@inheritdoc}
     */
    public function setBitbucketId($bitbucketId)
    {
        $this->bitbucketId = $bitbucketId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * {@inheritdoc}
     */
    public function addComment(CommentInterface $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeComment(CommentInterface $comment)
    {
        $this->comments->removeElement($comment);

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setGithubAccessToken($githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * {@inheritdoc}
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
    public function getReportedIssues()
    {
        return $this->reportedIssues;
    }

    /**
     * {@inheritdoc}
     */
    public function addReportedIssue(IssueInterface $issue)
    {
        $this->reportedIssues[] = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeReportedIssue(IssueInterface $issue)
    {
        $this->reportedIssues->removeElement($issue);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        parent::setUsername($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical($emailCanonical)
    {
        parent::setEmailCanonical($emailCanonical);
        parent::setUsernameCanonical($emailCanonical);

        return $this;
    }
}
