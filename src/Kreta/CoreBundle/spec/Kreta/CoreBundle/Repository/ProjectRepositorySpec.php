<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectRepositorySpec.
 *
 * @package spec\Kreta\CoreBundle\Repository
 */
class ProjectRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Repository\ProjectRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

//    function it_finds_by_participant(
//        UserInterface $participant,
//        EntityRepository $repository,
//        QueryBuilder $queryBuilder,
//        Expr $expr,
//        Expr\Comparison $comparison,
//        AbstractQuery $query
//    )
//    {
//        $repository->createQueryBuilder('p')->shouldBeCalled()->willReturn($queryBuilder);
//
//        $queryBuilder->select('p')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
//        $expr->eq('p.participants', ':participant')->shouldBeCalled()->willReturn($comparison);
//        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
//        $participant->getId()->shouldBeCalled()->willReturn('participant-id');
//        $queryBuilder->setParameter(':participant', 'participant-id')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
//        $query->getResult()->shouldBeCalled()->willReturn(array());
//
//        $this->findByParticipant($participant);
//    }
}
