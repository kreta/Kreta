<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusTransitionRepositorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Repository
 */
class StatusTransitionRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Repository\StatusTransitionRepository');
    }

    function it_extends_abstract_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\Abstracts\AbstractRepository');
    }

    function it_finds_by_workflow(
        WorkflowInterface $workflow,
        EntityManager $manager,
        QueryBuilder $queryBuilder,
        Expr $expr,
        Expr\Comparison $comparison,
        AbstractQuery $query,
        StatusTransitionInterface $statusTransition
    )
    {
        $manager->createQueryBuilder()->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->select('s')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), 's')->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->expr()->shouldBeCalled()->willReturn($expr);
        $expr->eq('s.workflow', ':workflow')->shouldBeCalled()->willReturn($comparison);
        $queryBuilder->where($comparison)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->setParameter('workflow', $workflow)->shouldBeCalled()->willReturn($queryBuilder);
        $queryBuilder->getQuery()->shouldBeCalled()->willReturn($query);
        $query->getResult()->shouldBeCalled()->willReturn([$statusTransition]);

        $this->findByWorkflow($workflow)->shouldBeArray();
    }
}
