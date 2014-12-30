<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model\Interfaces;

/**
 * Interface CommitInterface
 *
 * @package Kreta\Component\VCS\Model
 */
interface CommitInterface
{
    /**
     * Returns id
     *
     * @return string
     */
    public function getId();

    /**
     * Sets id
     *
     * @param string $id The id to be set
     *
     * @return string
     */
    public function setId($id);

    /**
     * Returns author
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Sets author
     *
     * @param string $author The author to be set
     *
     * @return self
     */
    public function setAuthor($author);

    /**
     * Gets branch
     *
     * @return BranchInterface
     */
    public function getBranch();

    /**
     * Gets branch
     *
     * @param BranchInterface $branch
     *
     * @return self
     */
    public function setBranch(BranchInterface $branch);

    /**
     * Returns issuesRelated
     *
     * @return mixed
     */
    public function getIssuesRelated();

    /**
     * Sets issuesRelated
     *
     * @param mixed $issuesRelated The issuesRelated to be set
     *
     * @return self
     */
    public function setIssuesRelated($issuesRelated);

    /**
     * Returns message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets message
     *
     * @param string $message The message to be set
     *
     * @return self
     */
    public function setMessage($message);

    /**
     * Returns sha
     *
     * @return string
     */
    public function getSha();

    /**
     * Sets sha
     *
     * @param string $sha The sha to be set
     *
     * @return self
     */
    public function setSha($sha);

    /**
     * Returns url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Sets url
     *
     * @param string $url The url to be set
     *
     * @return self
     */
    public function setUrl($url);
}
