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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusRepositorySpec.
 *
 * @package spec\Kreta\Component\Core\Repository
 */
class StatusRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\StatusRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

//    function it_finds_all(EntityRepository $repository, QueryBuilder $queryBuilder, AbstractQuery $query)
//    {
//        $repository->createQueryBuilder('s')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
//        $query->getResult()->shouldBeCalled()->willReturn(array());
//
//        $this->findAll()->shouldBeArray();
//    }
}
