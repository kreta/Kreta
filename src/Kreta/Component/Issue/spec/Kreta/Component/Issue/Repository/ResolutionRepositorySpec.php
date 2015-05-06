<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ResolutionRepositorySpec.
 *
 * @package spec\Kreta\Component\Issue\Repository
 */
class ResolutionRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Repository\ResolutionRepository');
    }

    function it_extends_kreta_entity_repository()
    {
        $this->shouldHaveType('Kreta\Component\Core\Repository\EntityRepository');
    }
}
