<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Comment\Model;

use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class Comment.
 *
 * @package Kreta\Component\Comment\Model
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
     * @var \Kreta\Component\Issue\Model\Interfaces\IssueInterface
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
     * @var \Symfony\Component\Security\Core\User\UserInterface
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
    public function setCreatedAt(\DateTime $createdAt)
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
    public function setUpdatedAt(\DateTime $updatedAt)
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
    public function setWrittenBy(UserInterface $writtenBy)
    {
        $this->writtenBy = $writtenBy;

        return $this;
    }
}
