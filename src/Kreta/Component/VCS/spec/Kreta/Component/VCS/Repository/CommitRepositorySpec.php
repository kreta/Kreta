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
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Prophecy\Argument;

/**
 * Class CommitRepositorySpec.
 *
 * @package spec\Kreta\Component\VCS\Repository
 */
class CommitRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Repository\CommitRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_issue(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        CommitInterface $commit
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['ir.id' => 'issue-id'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$commit]);

        $this->findByIssue('issue-id')->shouldReturn([$commit]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('c')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['b', 'ir'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'c', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('c.branch', 'b')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('c.issuesRelated', 'ir')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'c';
    }
}
