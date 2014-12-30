<?php
/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Serializer\Github;

use Kreta\Component\VCS\Factory\CommitFactory;
use Kreta\Component\VCS\Repository\BranchRepository;
use Kreta\Component\VCS\Repository\RepositoryRepository;
use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;

class CommitSerializer implements SerializerInterface {

    /** @var CommitFactory $factory */
    protected $factory;

    /** @var  RepositoryRepository $repositoryRepository */
    protected $repositoryRepository;

    /** @var  BranchRepository $branchRepository */
    protected $branchRepository;

    /**
     * Constructor.
     *
     * @param CommitFactory        $factory
     * @param RepositoryRepository $repositoryRepository
     * @param BranchRepository     $branchRepository
     */
    public function __construct(CommitFactory $factory, RepositoryRepository $repositoryRepository,
                                BranchRepository $branchRepository)
    {
        $this->factory = $factory;
        $this->repositoryRepository = $repositoryRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($json)
    {
        $json = json_decode($json, true);

        $jsonCommit = $json['head_commit'];

        $repository = $this->repositoryRepository->findOneBy(['name' => $json['repository']['full_name']]);
        if(!$repository) {
            return null;
        }

        $branchName = str_replace('refs/heads/', '', $json['ref']);
        $branch = $this->branchRepository->findOrCreateBranch($repository, $branchName);

        $commit = $this->factory->create($jsonCommit['id'], $jsonCommit['message'], $branch,
            $jsonCommit['author']['username'], $jsonCommit['url']);

        return $commit;
    }
}
