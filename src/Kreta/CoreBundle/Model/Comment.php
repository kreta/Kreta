<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Model;

use Kreta\CoreBundle\Model\Abstracts\AbstractModel;
use Kreta\CoreBundle\Model\Interfaces\CommentInterface;
use Kreta\CoreBundle\Model\Interfaces\IssueInterface;

/**
 * Class Comment.
 *
 * @package Kreta\CoreBundle\Model
 */
class Comment extends AbstractModel implements CommentInterface
{
    /**
     * Created at.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * The description.
     *
     * @var string
     */
    protected $description;

    /**
     * The issue.
     *
     * @var \Kreta\CoreBundle\Model\Interfaces\IssueInterface
     */
    protected $issue;

    /**
     * Created at.
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * The owner.
     *
     * @var \Kreta\CoreBundle\Model\Interfaces\UserInterface
     */
    protected $writtenBy;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * {@inheritdoc}
     */
    public function setIssue(IssueInterface $issue)
    {
        $this->issue = $issue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWrittenBy()
    {
        return $this->writtenBy;
    }

    /**
     * {@inheritdoc}
     */
    public function setWrittenBy($writtenBy)
    {
        $this->writtenBy = $writtenBy;

        return $this;
    }
}
