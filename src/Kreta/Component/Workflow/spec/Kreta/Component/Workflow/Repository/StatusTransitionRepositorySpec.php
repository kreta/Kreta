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

namespace spec\Kreta\Component\Workflow\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Kreta\Component\Core\spec\Kreta\Component\Core\Repository\BaseEntityRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusTransitionRepositorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class StatusTransitionRepositorySpec extends ObjectBehavior
{
    use BaseEntityRepository;

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
