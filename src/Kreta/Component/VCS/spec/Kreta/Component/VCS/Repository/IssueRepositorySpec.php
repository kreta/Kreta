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
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Prophecy\Argument;

/**
 * Class IssueRepositorySpec.
 *
 * @package spec\Kreta\Component\VCS\Repository
 */
class IssueRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, IssueRepository $issueRepository)
    {
        $manager->getRepository('Kreta\Component\Issue\Model\Issue')->shouldBeCalled()->willReturn($issueRepository);
        $this->beConstructedWith($manager, 'Kreta\Component\Issue\Model\Issue');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Repository\IssueRepository');
    }

    function it_finds_related_issues_by_repository(
        RepositoryInterface $repository,
        ProjectInterface $project,
        ProjectInterface $project2,
        IssueRepository $issueRepository,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Func $func,
        AbstractQuery $query,
        IssueInterface $issue
    )
    {
        $repository->getProjects()->shouldBeCalled()->willReturn([$project, $project2]);
        $project->getId()->shouldBeCalled()->willReturn('repository-id');
        $project2->getId()->shouldBeCalled()->willReturn('repository-id-2');

        $issueRepository->createQueryBuilder('i')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('i.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->in('i.project', ['repository-id', 'repository-id-2'])->shouldBeCalled()->willReturn($func);
        $queryBuilder->where($func)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.shortName = :shortName')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->andWhere('i.numericId = :numericId')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('shortName', 'KRT')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('numericId', 10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$issue]);

        $this->findRelatedIssuesByRepository($repository, 'KRT', 10)->shouldReturn([$issue]);
    }
}
