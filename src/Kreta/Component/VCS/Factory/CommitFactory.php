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

/**
 * Interface CommitFactoryInterface
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
     * Creates a Commit object with the given response by the VCS provider
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\CommitInterface
     */
    public function create($sha, $message, $repository, $author, $provider, $url)
    {
        /**
         * @var \Kreta\Component\VCS\Model\Interfaces\CommitInterface
         */
        $commit = new $this->className;
        $commit->setSHA($sha);
        $commit->setMessage($message);
        $commit->setRepository($repository);
        $commit->setAuthor($author);
        $commit->setProvider($provider);
        $commit->setUrl($url);
    }
} 
