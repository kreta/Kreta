<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\User\Model;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class User.
 *
 * @package Kreta\Component\User\Model
 */
class User extends BaseUser implements UserInterface
{
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
     * The photo.
     *
     * @var \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    protected $photo;

    /**
     * Array that contains all the projects with his roles.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $projects;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->projects = new ArrayCollection();

        parent::__construct();
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
    public function getFullName()
    {
        if ($this->firstName !== null && $this->lastName !== null) {
            return $this->firstName . ' ' . $this->lastName;
        }

        if ($this->firstName !== null) {
            return $this->firstName;
        }

        if ($this->lastName !== null) {
            return $this->lastName;
        }
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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoto(MediaInterface $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject(ParticipantInterface $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProject(ParticipantInterface $project)
    {
        $this->projects->removeElement($project);

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
