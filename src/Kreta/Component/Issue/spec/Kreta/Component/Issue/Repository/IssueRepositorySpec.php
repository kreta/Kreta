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
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\Abstracts\BaseRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Prophecy\Argument;

/**
 * Class IssueRepositorySpec.
 *
 * @package spec\Kreta\Component\Issue\Repository
 */
class IssueRepositorySpec extends BaseRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Repository\IssueRepository');
    }

    function it_extends_abstract_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\Abstracts\AbstractRepository');
    }

    function it_finds_by_project(
        ProjectInterface $project,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['project' => $project], $comparison);
        $this->addCriteriaSpec($queryBuilder, $expr, ['title' => 'project name'], $comparison, 'like');
        $this->orderBySpec($queryBuilder, ['title' => 'DESC']);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findByProject($project, ['title' => 'project name'], ['title' => 'DESC'], 10, 1)
            ->shouldReturn([$issue]);
    }

    function it_finds_by_reporter(
        UserInterface $reporter,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('i.reporter', ':reporter')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $reporter->getId()->shouldBeCalled()->willReturn('reporter-id');
        $queryBuilder->setParameter(':reporter', 'reporter-id')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findByReporter($reporter)->shouldBeArray();
    }

    function it_finds_by_assignee(
        UserInterface $assignee,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.status', 'st')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('i.assignee', ':assignee')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $assignee->getId()->shouldBeCalled()->willReturn('assignee-id');
        $queryBuilder->setParameter(':assignee', 'assignee-id')->shouldBeCalled()->willReturn($queryBuilder);
        $this->orderBySpec($queryBuilder, ['status' => 'DESC']);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findByAssignee($assignee, ['status' => 'DESC'], false)->shouldBeArray();
    }

    function it_finds_only_open_issues_by_assignee(
        UserInterface $assignee,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.status', 'st')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('i.assignee', ':assignee')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $assignee->getId()->shouldBeCalled()->willReturn('assignee-id');
        $queryBuilder->setParameter(':assignee', 'assignee-id')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->neq('st.type', ':state')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->andWhere($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter(':state', 'final')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findByAssignee($assignee, [], true)->shouldBeArray();
    }

    function it_finds_one_issue_by_short_code(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        Expr\Comparison $comparison2,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('i.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('p.workflow', 'w')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalledTimes(2)->willReturn($expr);
        $expr->eq('i.numericId', ':issueNumber')->shouldBeCalled()->willReturn($comparison);
        $expr->eq('p.shortName', ':projectShortName')->shouldBeCalled()->willReturn($comparison2);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere($comparison2)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('issueNumber', 42)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('projectShortName', 'KRT')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getOneOrNullResult()->shouldBeCalled()->willReturn($issue);

        $this->findOneByShortCode('KRT', 42)->shouldReturn($issue);
    }

    function it_finds_by_workflow(
        WorkflowInterface $workflow,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('i.project', 'pr')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('pr.workflow', ':workflow')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('workflow', $workflow)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findByWorkflow($workflow)->shouldBeArray();
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['a', 'c', 'l', 'p', 'r', 'rep', 's', 'w'])
            ->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.assignee', 'a')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.comments', 'c')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.labels', 'l')->shouldBeCalled()->willReturn($queryBuilder);
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
