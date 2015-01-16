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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Prophecy\Argument;

/**
 * Class StatusTransitionRepositorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Repository
 */
class StatusTransitionRepositorySpec extends BaseEntityRepository
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Repository\StatusTransitionRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }
    
    function it_persists_initial_status(StatusTransitionInterface $transition, StatusInterface $initialStatus)
    {
        $transition->addInitialState($initialStatus)->shouldBeCalled()->willReturn($transition);

        $this->persistInitialStatus($transition, $initialStatus);
    }

    function it_removes_initial_status(StatusTransitionInterface $transition, StatusInterface $initialStatus)
    {
        $transition->getInitialState('initial-status-id')->shouldBeCalled()->willReturn($initialStatus);
        $transition->removeInitialState($initialStatus)->shouldBeCalled()->willReturn($transition);

        $this->removeInitialStatus($transition, 'initial-status-id');
    }
}
