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

namespace spec\Kreta\Component\Organization\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec file of OrganizationRepository class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationRepositorySpec extends ObjectBehavior
{
    use BaseEntityRepository;

    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Repository\OrganizationRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_participant(
        OrganizationInterface $organization,
        UserInterface $user,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    ) {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['par.user' => $user], $comparison);
        $this->orderBySpec($queryBuilder, ['name' => 'ASC']);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$organization]);

        $this->findByParticipant($user, ['name' => 'ASC'], 10, 1)->shouldReturn([$organization]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('o')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['img', 'p'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'o', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('o.image', 'img')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->leftJoin('o.projects', 'p')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('o.participants', 'par')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'o';
    }
}
