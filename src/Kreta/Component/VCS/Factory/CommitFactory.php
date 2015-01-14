<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Factory;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;

/**
 * Class CommitFactory.
 *
 * @package Kreta\Component\VCS\Factory
 */
class CommitFactory
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
     * Creates a Commit object with the given response by the VCS provider.
     *
     * @param string                                                $sha     The sha
     * @param string                                                $message The message
     * @param \Kreta\Component\VCS\Model\Interfaces\BranchInterface $branch  The branch
     * @param string                                                $author  the author
     * @param string                                                $url     The url
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\CommitInterface
     */
    public function create($sha, $message, BranchInterface $branch, $author, $url)
    {
        $commit = new $this->className;

        return $commit
            ->setSHA($sha)
            ->setMessage($message)
            ->setBranch($branch)
            ->setAuthor($author)
            ->setUrl($url);
    }
}
