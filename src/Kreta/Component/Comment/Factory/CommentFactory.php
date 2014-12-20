<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Comment\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class CommentFactory
 *
 * @package Kreta\Component\Comment\Factory
 */
class CommentFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of comment.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface   $user  The user
     *
     * @return \Kreta\Component\Comment\Model\Interfaces\CommentInterface
     */
    public function create(IssueInterface $issue, UserInterface $user)
    {
        $comment = new $this->className;

        return $comment
            ->setIssue($issue)
            ->setWrittenBy($user);
    }
} 
