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
 * Interface PullRequestInterface
 *
 * @package Kreta\Component\VCS\Model
 */
interface PullRequestInterface
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
     * @return self
     */
    public function setId($id);

    /**
     * Returns the number given to the pull request by the provider
     *
     * @return integer
     */
    public function getNumber();

    /**
     * Sets the number given to the pull request by the provider
     *
     * @param integer $number
     *
     * @return self
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
     * @return self
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
     * @param string $message
     *
     * @return self
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
     * @param string $author
     *
     * @return self
     */
    public function setAuthor($author);

    public function getIssuesRelated();
}
