<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Matcher;

use Kreta\Component\VCS\Matcher\Interfaces\MatcherInterface;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Kreta\Component\VCS\Repository\IssueRepository;

class CommitMatcher implements MatcherInterface
{
    /**
     * @var IssueRepository $issueRepository
     */
    protected $issueRepository;

    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedIssues(CommitInterface $commit)
    {
        if (!$commit->getBranch()) {
            return [];
        }

        return array_merge(
            $this->findRelatedIssues($commit->getBranch()->getRepository(), $commit->getMessage()),
            $this->findRelatedIssues($commit->getBranch()->getRepository(), $commit->getBranch()->getName())
        );


    }

    /**
     * Finds related issues for repository and message given
     *
     * @param RepositoryInterface $repository
     * @param string              $message
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
     * @param $message
     *
     * @return string[]
     */
    protected function findShortNamesInMessage($message)
    {
        preg_match('/[A-Z0-9]{3,4}-[0-9]{1,}/', $message, $matches);
        return $matches;
    }
}
