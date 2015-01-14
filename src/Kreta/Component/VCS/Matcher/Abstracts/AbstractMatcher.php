<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Matcher\Abstracts;

use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Kreta\Component\VCS\Repository\IssueRepository;

/**
 * Abstract class AbstractMatcher
 *
 * @package Kreta\Component\VCS\Matcher\Abstracts
 */
abstract class AbstractMatcher
{
    /**
     * The issue repository.
     *
     * @var \Kreta\Component\VCS\Repository\IssueRepository
     */
    protected $issueRepository;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\VCS\Repository\IssueRepository $issueRepository The issue repository
     */
    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    /**
     * Gets related issues.
     *
     * @param mixed $entity The entity
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    abstract public function getRelatedIssues($entity);

    /**
     * Finds related issues for repository and message given.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface $repository The repository
     * @param string                                                    $message    The message
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    protected function findRelatedIssues(RepositoryInterface $repository, $message)
    {
        $issues = [];

        foreach ($this->findShortnamesInMessage($message) as $shortName) {
            $shortNameAndNumber = explode('-', $shortName);
            $issues = array_merge($this->issueRepository->findRelatedIssuesByRepository(
                $repository, $shortNameAndNumber[0], $shortNameAndNumber[1]
            ), $issues);
        }

        return $issues;
    }

    /**
     * Returns the complete string matching shortName-numericId format (f.e. KRT-42) found in the string given.
     *
     * @param string $message The message
     *
     * @return string[]
     */
    protected function findShortNamesInMessage($message)
    {
        preg_match('/[A-z0-9]{3,4}-[0-9]{1,}/', $message, $matches);

        return $matches;
    }
}
