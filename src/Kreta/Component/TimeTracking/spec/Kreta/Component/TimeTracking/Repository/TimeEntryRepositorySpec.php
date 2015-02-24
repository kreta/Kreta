<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\TimeTracking\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface;
use Prophecy\Argument;

/**
 * Class TimeEntryRepositorySpec
 *
 * @package spec\Kreta\Component\TimeTracking\Repository
 */
class TimeEntryRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\TimeTracking\Repository\TimeEntryRepository');
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
        IssueInterface $issue,
        TimeEntryInterface $timeEntry
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['issue' => $issue], $comparison);
        $this->orderBySpec($queryBuilder, ['dateReported' => 'ASC']);
        $queryBuilder->setMaxResults(1)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$timeEntry]);

        $this->findByIssue($issue, ['dateReported' => 'ASC'], 1, 1)->shouldReturn([$timeEntry]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('t')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['i'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 't', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('t.issue', 'i')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 't';
    }
}
