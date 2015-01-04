<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Repository\Abstracts;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AbstractRepositorySpec.
 *
 * @package spec\Kreta\Component\Core\Repository\Abstracts
 */
class AbstractRepositorySpec extends ObjectBehavior
{
    function let(EntityManager $manager, ClassMetadata $metadata)
    {
        $this->beAnInstanceOf('Kreta\Component\Core\Stubs\Repository\Abstracts\AbstractRepositoryStub');
        $this->beConstructedWith($manager, $metadata);
    }

    function it_persists_without_flush(EntityManager $manager)
    {
        $manager->persist(Argument::type('Object'))->shouldBeCalled();

        $this->persist(Argument::type('Object'), false);
    }

    function it_persists_with_flush(EntityManager $manager)
    {
        $manager->persist(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->persist(Argument::type('Object'), true);
    }

    function it_removes_without_flush(EntityManager $manager)
    {
        $manager->remove(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->remove(Argument::type('Object'), true);
    }

    function it_removes_with_flush(EntityManager $manager)
    {
        $manager->remove(Argument::type('Object'))->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->remove(Argument::type('Object'), true);
    }
}
