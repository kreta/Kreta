<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\User\Model\Interfaces;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;

/**
 * Interface UserInterface.
 *
 * @package Kreta\Component\User\Model\Interfaces
 */
interface UserInterface extends BaseUserInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets assigned issues.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getAssignedIssues();

    /**
     * Adds assigned issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The assigned issue
     *
     * @return $this self Object
     */
    public function addAssignedIssue(IssueInterface $issue);

    /**
     * Removes assigned issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The assigned issue
     *
     * @return $this self Object
     */
    public function removeAssignedIssue(IssueInterface $issue);

    /**
     * Sets id.
     *
     * @param string $id The id
     *
     * @return self Object $this
     */
    public function setId($id);

    /**
     * Gets Bitbucket access token.
     *
     * @return string
     */
    public function getBitbucketAccessToken();

    /**
     * Sets Bitbucket access token.
     *
     * @param string $bitbucketAccessToken The Bitbucket access token
     *
     * @return $this self Object
     */
    public function setBitbucketAccessToken($bitbucketAccessToken);

    /**
     * Gets Bitbucket id.
     *
     * @return string
     */
    public function getBitbucketId();

    /**
     * Sets Bitbucket id.
     *
     * @param string $bitbucketId The Bitbucket id
     *
     * @return $this self Object
     */
    public function setBitbucketId($bitbucketId);

    /**
     * Gets created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets created at.
     *
     * @param \DateTime $createdAt The created at.
     *
     * @return $this self Object
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Sets first name.
     *
     * @param string $firstName The first name
     *
     * @return $this self Object
     */
    public function setFirstName($firstName);

    /**
     * Gets GitHub access token.
     *
     * @return string
     */
    public function getGithubAccessToken();

    /**
     * Sets GitHub access token.
     *
     * @param string $githubAccessToken The GitHub access token
     *
     * @return $this self Object
     */
    public function setGithubAccessToken($githubAccessToken);

    /**
     * Gets GitHub id.
     *
     * @return string
     */
    public function getGithubId();

    /**
     * Sets GitHub id.
     *
     * @param string $githubId The GitHub id
     *
     * @return $this self Object
     */
    public function setGithubId($githubId);

    /**
     * Gets last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Sets last name.
     *
     * @param string $lastName The last name
     *
     * @return $this self Object
     */
    public function setLastName($lastName);

    /**
     * Gets photo.
     *
     * @return \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    public function getPhoto();

    /**
     * Sets photo.
     *
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface $photo The photo
     *
     * @return $this self Object
     */
    public function setPhoto(MediaInterface $photo);

    /**
     * Gets project with his role.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface[]
     */
    public function getProjects();

    /**
     * Adds project with his role.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ParticipantInterface $project The project
     *
     * @return $this self Object
     */
    public function addProject(ParticipantInterface $project);

    /**
     * Removes project with his role.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ParticipantInterface $project The project
     *
     * @return $this self Object
     */
    public function removeProject(ParticipantInterface $project);

    /**
     * Gets reported issues.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getReportedIssues();

    /**
     * Adds reported issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The reported issue
     *
     * @return $this self Object
     */
    public function addReportedIssue(IssueInterface $issue);

    /**
     * Removes reported issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The reported issue
     *
     * @return $this self Object
     */
    public function removeReportedIssue(IssueInterface $issue);
}
