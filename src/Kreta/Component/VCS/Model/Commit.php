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

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;

/**
     * {@inheritdoc}
     */
class Commit implements CommitInterface
{
    protected $id;

    protected $author;

    protected $branch;

    protected $issuesRelated;

    protected $message;

    protected $sha;

    protected $url;

    /** 
     * {@inheritdoc} 
     */
    public function getId()
    {
        return $this->id;
    }

    /** 
    * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /** 
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /** 
     * {@inheritdoc}
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * {@inheritdoc}
     */
    public function setBranch(BranchInterface $branch)
    {
        $this->branch = $branch;

        return $this;
    }


    /** 
     * {@inheritdoc}
     */
    public function getIssuesRelated()
    {
        return $this->issuesRelated;
    }

    /** 
     * {@inheritdoc}
     */
    public function setIssuesRelated($issuesRelated)
    {
        $this->issuesRelated = $issuesRelated;

        return $this;
    }

    /** 
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /** 
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSha()
    {
        return $this->sha;
    }

    /** 
     * {@inheritdoc}
     */
    public function setSha($sha)
    {
        $this->sha = $sha;

        return $this;
    }

    /** 
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /** 
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
