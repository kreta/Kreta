<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class CommentFactory
 *
 * @package Kreta\Component\Core\Factory
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

    public function create(IssueInterface $issue, UserInterface $user)
    {
        $comment = new $this->className;

        $comment->setWrittenBy($user);
        $comment->setIssue($issue);

        return $comment;
    }

} 
