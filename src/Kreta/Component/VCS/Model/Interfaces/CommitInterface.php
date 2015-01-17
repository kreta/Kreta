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
 * Interface CommitInterface.
 *
 * @package Kreta\Component\VCS\Model\Interfaces
 */
interface CommitInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets author.
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Sets author.
     *
     * @param string $author The author to be set
     *
     * @return $this self Object
     */
    public function setAuthor($author);

    /**
     * Gets branch.
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    public function getBranch();

    /**
     * Gets branch.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\BranchInterface $branch The branch
     *
     * @return $this self Object
     */
    public function setBranch(BranchInterface $branch);

    /**
     * Gets issues related.
     *
     * @return mixed
     */
    public function getIssuesRelated();

    /**
     * Sets issues related.
     *
     * @param mixed $issuesRelated The issuesRelated to be set
     *
     * @return $this self Object
     */
    public function setIssuesRelated($issuesRelated);

    /**
     * Gets message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets message.
     *
     * @param string $message The message to be set
     *
     * @return $this self Object
     */
    public function setMessage($message);

    /**
     * Gets sha.
     *
     * @return string
     */
    public function getSha();

    /**
     * Sets sha.
     *
     * @param string $sha The sha to be set
     *
     * @return $this self Object
     */
    public function setSha($sha);

    /**
     * Gets url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Sets url.
     *
     * @param string $url The url to be set
     *
     * @return $this self Object
     */
    public function setUrl($url);
}
