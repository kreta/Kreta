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

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;

/**
 * Interface UserInterface.
 *
 * @package Kreta\Component\Core\Model\Interfaces
 */
interface UserInterface extends BaseUserInterface
{
    /**
     * Gets assigned issues.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function getAssignedIssues();

    /**
     * Adds assigned issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The assigned issue
     *
     * @return $this self Object
     */
    public function addAssignedIssue(IssueInterface $issue);

    /**
     * Removes assigned issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The assigned issue
     *
     * @return $this self Object
     */
    public function removeAssignedIssue(IssueInterface $issue);

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

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
     * Gets comments.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\CommentInterface[]
     */
    public function getComments();

    /**
     * Adds comment.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\CommentInterface $comment The comment
     *
     * @return $this self Object
     */
    public function addComment(CommentInterface $comment);

    /**
     * Removes comment.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\CommentInterface $comment The comment
     *
     * @return $this self Object
     */
    public function removeComment(CommentInterface $comment);

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
     * Gets projects.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface[]
     */
    public function getProjects();

    /**
     * Adds project.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function addProject(ProjectInterface $project);

    /**
     * Removes project.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function removeProject(ProjectInterface $project);

    /**
     * Gets reported issues.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function getReportedIssues();

    /**
     * Adds reported issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The reported issue
     *
     * @return $this self Object
     */
    public function addReportedIssue(IssueInterface $issue);

    /**
     * Removes reported issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface $issue The reported issue
     *
     * @return $this self Object
     */
    public function removeReportedIssue(IssueInterface $issue);
}
