<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BranchRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Repository\BranchRepository');
    }

    function it_finds_exiting_branch(EntityManager $manager, QueryBuilder $queryBuilder, AbstractQuery $query,
                                     BranchInterface $branch, RepositoryInterface $repository)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'b')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->where('b.name = :branchName')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere('b.repository = :repositoryId')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('branchName', 'master')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('repositoryId', '2222')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($branch);

        $repository->getId()->shouldBeCalled()->willReturn('2222');

        $this->findOrCreateBranch($repository, 'master')->shouldReturn($branch);
    }

    function it_creates_a_new_branch(EntityManager $manager, QueryBuilder $queryBuilder, AbstractQuery $query,
                                     RepositoryInterface $repository)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'b')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->where('b.name = :branchName')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere('b.repository = :repositoryId')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('branchName', 'master')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('repositoryId', '2222')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willThrow(new NoResultException());

        $manager->persist(Argument::type('Kreta\Component\VCS\Model\Interfaces\BranchInterface'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $repository->getId()->shouldBeCalled()->willReturn('2222');

        $this->findOrCreateBranch($repository, 'master')
            ->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Interfaces\BranchInterface');
    }

    function it_finds_by_issue(EntityManager $manager, QueryBuilder $queryBuilder, AbstractQuery $query,
                               BranchInterface $branch)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('b.issuesRelated', 'ir', 'WITH', 'ir.id = :issueId')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('issueId', '1111')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$branch]);

        $this->findByIssue('1111')->shouldReturn([$branch]);
    }
} 
