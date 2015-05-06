<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Prophecy\Argument;

/**
 * Class ParticipantRepositorySpec.
 *
 * @package spec\Kreta\Component\Project\Repository
 */
class ParticipantRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Repository\ParticipantRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_project(
        ParticipantInterface $participant,
        ProjectInterface $project,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    )
    {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['project' => $project], $comparison);
        $this->addLikeCriteriaSpec($queryBuilder, $expr, ['u.email' => 'kreta@kreta.com'], $comparison);
        $this->orderBySpec($queryBuilder, ['u.email' => 'ASC']);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$participant]);

        $this->findByProject($project, 10, 1, 'kreta@kreta.com')->shouldReturn([$participant]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('par')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['p', 'u'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'par', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('par.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('par.user', 'u')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'par';
    }
}
