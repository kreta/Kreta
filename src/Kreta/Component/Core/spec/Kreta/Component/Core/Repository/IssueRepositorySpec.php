<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueRepositorySpec.
 *
 * @package spec\Kreta\Component\Core\Repository
 */
class IssueRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\IssueRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

    function it_finds_by_project(
        ProjectInterface $project,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select(['i', 'a', 'c', 'l', 'p', 'r', 'rep', 's', 'w'])
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
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('i.project', ':project')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $project->getId()->shouldBeCalled()->willReturn('project-id');
        $queryBuilder->andWhere(' 1=1 AND i.title LIKE :title AND a.email LIKE :aemail ')
            ->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameters(
            ['title' => '%title-of-project%', 'aemail' => '%user@kreta.com%', 'project' => 'project-id']
        )->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(0)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->orderBy('i.status', 'DESC')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([]);

        $this->findByProject(
            $project,
            ['status' => 'DESC'],
            10,
            0,
            ['title' => 'title-of-project', 'a.email' => 'user@kreta.com']
        )->shouldBeArray();
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

    function it_does_not_find_by_assignee_because_the_order_is_not_a_valid_filter(
        UserInterface $assignee,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison
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

        $this->shouldThrow(new \Exception('unknown-filter is not a valid filter'))
            ->during('findByAssignee', [$assignee, ['unknown-filter' => 'DESC'], false]);
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
        $queryBuilder->orderBy('i.status', 'DESC')->shouldBeCalled()->willReturn($queryBuilder);
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

    function it_finds_one_issue_by_shortcode (
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
        $queryBuilder->leftJoin('i.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
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
}
