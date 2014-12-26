<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Model;

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;

/**
 * Class Commit
 *
 * @package Kreta\Component\VCS\Model
 */
class Commit implements CommitInterface
{
    protected $id;

    protected $author;

    protected $issuesRelated;

    protected $message;

    protected $provider;

    protected $repository;

    protected $sha;

    protected $url;

    /**
     * Returns id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id
     *
     * @param mixed $id The id to be set
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns author
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets author
     *
     * @param mixed $author The author to be set
     *
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Returns issuesRelated
     *
     * @return mixed
     */
    public function getIssuesRelated()
    {
        return $this->issuesRelated;
    }

    /**
     * Sets issuesRelated
     *
     * @param mixed $issuesRelated The issuesRelated to be set
     *
     * @return self
     */
    public function setIssuesRelated($issuesRelated)
    {
        $this->issuesRelated = $issuesRelated;

        return $this;
    }

    /**
     * Returns message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets message
     *
     * @param mixed $message The message to be set
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Returns provider
     *
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Sets provider
     *
     * @param mixed $provider The provider to be set
     *
     * @return self
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Returns repository
     *
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets repository
     *
     * @param mixed $repository The repository to be set
     *
     * @return self
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Returns sha
     *
     * @return mixed
     */
    public function getSha()
    {
        return $this->sha;
    }

    /**
     * Sets sha
     *
     * @param mixed $sha The sha to be set
     *
     * @return self
     */
    public function setSha($sha)
    {
        $this->sha = $sha;

        return $this;
    }

    /**
     * Returns url
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets url
     *
     * @param mixed $url The url to be set
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
