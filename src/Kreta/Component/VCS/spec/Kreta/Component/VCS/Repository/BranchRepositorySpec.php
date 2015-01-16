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
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Prophecy\Argument;

/**
 * Class BranchRepositorySpec.
 *
 * @package spec\Kreta\Component\VCS\Repository
 */
class BranchRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Repository\BranchRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_exiting_branch(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        BranchInterface $branch,
        RepositoryInterface $repository,
        BranchInterface $branch
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'master'], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['repository' => $repository], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willReturn($branch);

        $this->findOrCreateBranch($repository, 'master')->shouldReturn($branch);
    }

    function it_creates_a_new_branch(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        RepositoryInterface $repository
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['name' => 'master'], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['repository' => $repository], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getSingleResult()->shouldBeCalled()->willThrow(new NoResultException());

        $manager->persist(Argument::type('Kreta\Component\VCS\Model\Interfaces\BranchInterface'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->findOrCreateBranch($repository, 'master')
            ->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Interfaces\BranchInterface');
    }

    function it_finds_by_issue(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        BranchInterface $branch
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['ir.id' => 'issue-id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$branch]);

        $this->findByIssue('issue-id')->shouldReturn([$branch]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['ir', 'r'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('b.issuesRelated', 'ir')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('b.repository', 'r')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'b';
    }
}
