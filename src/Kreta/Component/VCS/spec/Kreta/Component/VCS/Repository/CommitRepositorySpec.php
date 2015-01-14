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
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CommitRepositorySpec.
 *
 * @package spec\Kreta\Component\VCS\Repository
 */
class CommitRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $classMetadata)
    {
        $this->beConstructedWith($manager, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Repository\CommitRepository');
    }

    function it_extends_entity_repository()
    {
        $this->shouldHaveType('Doctrine\ORM\EntityRepository');
    }

    function it_finds_by_issue(
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        AbstractQuery $query,
        CommitInterface $commit
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('c')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 'c')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->innerJoin('c.issuesRelated', 'ri', 'WITH', 'ri.id = :issueId')
            ->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('issueId', '1111')->shouldBeCalled()->willReturn($queryBuilder);

        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$commit]);

        $this->findByIssue('1111')->shouldReturn([$commit]);
    }
}
