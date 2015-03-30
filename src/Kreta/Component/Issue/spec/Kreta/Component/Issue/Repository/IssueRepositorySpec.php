<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Prophecy\Argument;

/**
 * Class IssueRepositorySpec.
 *
 * @package spec\Kreta\Component\Issue\Repository
 */
class IssueRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Repository\IssueRepository');
    }

    function it_extends_kretas_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_assignee(
        UserInterface $assignee,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['assignee' => $assignee], $comparison);
        $this->orderBySpec($queryBuilder, ['status' => 'DESC']);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findByAssignee($assignee, ['status' => 'DESC'], false)->shouldReturn([$issue]);
    }

    function it_finds_only_open_issues_by_assignee(
        UserInterface $assignee,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['assignee' => $assignee], $comparison);
        $this->addNeqCriteriaSpec($queryBuilder, $expr, ['s.type' => 'final'], $comparison);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findByAssignee($assignee, [], true)->shouldReturn([$issue]);
    }

    function it_finds_one_issue_by_short_code(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['numericId' => 42], $comparison);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['p.shortName' => 'KRT'], $comparison);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getOneOrNullResult()->shouldBeCalled()->willReturn($issue);

        $this->findOneByShortCode('KRT', 42)->shouldReturn($issue);
    }

    function it_finds_by_participant(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue,
        UserInterface $user
    )
    {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $queryBuilder->addSelect('par')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('p.participants', 'par')->shouldBeCalled()->willReturn($queryBuilder);
        $this->addEqCriteriaSpec($queryBuilder, $expr, ['par.user' => $user], $comparison);
        $queryBuilder->setMaxResults(4)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(2)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findByParticipant($user, [], [], 4, 2)->shouldReturn([$issue]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['a', 't', 'pr', 'p', 'r', 'rep', 's', 'w'])
            ->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.assignee', 'a')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.type', 't')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.priority', 'pr')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.resolution', 'r')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.reporter', 'rep')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.status', 's')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.watchers', 'w')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'i';
    }
}
