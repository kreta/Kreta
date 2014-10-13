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
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;

/**
 * Class LabelRepositorySpec.
 *
 * @package spec\Kreta\CoreBundle\Repository
 */
class LabelRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Repository\LabelRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

//    function it_finds_all(EntityRepository $repository, QueryBuilder $queryBuilder, AbstractQuery $query)
//    {
//        $repository->createQueryBuilder('l')->shouldBeCalled()->willReturn($queryBuilder);
//        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
//        $query->getResult()->shouldBeCalled()->willReturn(array());
//
//        $this->findAll()->shouldBeArray();
//    }
}
