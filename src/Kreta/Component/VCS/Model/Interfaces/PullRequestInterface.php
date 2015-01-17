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
 * Interface PullRequestInterface.
 *
 * @package Kreta\Component\VCS\Model\Interfaces
 */
interface PullRequestInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets the number given to the pull request by the provider.
     *
     * @return int
     */
    public function getNumber();

    /**
     * Sets the number given to the pull request by the provider.
     *
     * @param int $number The number
     *
     * @return $this self Object
     */
    public function setNumber($number);

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets the title.
     *
     * @param string $title The title
     *
     * @return $this self Object
     */
    public function setTitle($title);

    /**
     * Gets the message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets the message.
     *
     * @param string $message The message
     *
     * @return $this self Object
     */
    public function setMessage($message);

    /**
     * Gets the author.
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Sets the author.
     *
     * @param string $author The author
     *
     * @return $this self Object
     */
    public function setAuthor($author);

    /**
     * Gets issues related.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function getIssuesRelated();
}
