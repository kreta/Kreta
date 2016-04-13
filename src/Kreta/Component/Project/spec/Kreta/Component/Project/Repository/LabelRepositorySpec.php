<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Component\Project\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LabelRepositorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LabelRepositorySpec extends ObjectBehavior
{
    use BaseEntityRepository;

    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Repository\LabelRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_project(
        ProjectInterface $project,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        LabelInterface $label
    ) {
        $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['project' => $project], $comparison);
        $this->addLikeCriteriaSpec($queryBuilder, $expr, ['name' => 'java'], $comparison);
        $this->orderBySpec($queryBuilder, ['name' => 'ASC']);
        $queryBuilder->setMaxResults(4)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(2)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$label]);

        $this->findByProject($project, 4, 2, 'java')->shouldReturn([$label]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('l')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['p'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'l', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('l.project', 'p')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'l';
    }
}
