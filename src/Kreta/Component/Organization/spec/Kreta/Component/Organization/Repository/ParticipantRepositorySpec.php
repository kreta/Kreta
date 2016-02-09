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
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec file of ParticipantRepository class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantRepositorySpec extends ObjectBehavior
{
    use BaseEntityRepository;

    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Repository\ParticipantRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }

    function it_finds_by_organization(
        ParticipantInterface $participant,
        OrganizationInterface $organization,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query
    ) {
        $queryBuilder = $this->getQueryBuilderSpec($manager, $queryBuilder);
        $this->addCriteriaSpec($queryBuilder, $expr, ['organization' => $organization], $comparison);
        $this->addLikeCriteriaSpec($queryBuilder, $expr, ['u.email' => 'kreta@kreta.com'], $comparison);
        $this->orderBySpec($queryBuilder, ['u.email' => 'ASC']);
        $queryBuilder->setMaxResults(10)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setFirstResult(1)->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$participant]);

        $this->findByOrganization($organization, 10, 1, 'kreta@kreta.com')->shouldReturn([$participant]);
    }

    protected function getQueryBuilderSpec(EntityManager $manager, QueryBuilder $queryBuilder)
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('par')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->addSelect(['o', 'u'])->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'par', null)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('par.organization', 'o')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->join('par.user', 'u')->shouldBeCalled()->willReturn($queryBuilder);

        return $queryBuilder;
    }

    protected function getAlias()
    {
        return 'par';
    }
}
