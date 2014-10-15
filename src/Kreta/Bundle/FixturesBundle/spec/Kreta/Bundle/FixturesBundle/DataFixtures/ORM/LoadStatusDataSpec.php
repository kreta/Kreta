<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\StatusFactory;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadStatusDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle
 */
class LoadStatusDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, ReferenceRepository $referenceRepository)
    {
        $this->setContainer($container);
        $this->setReferenceRepository($referenceRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadStatusData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        StatusFactory $factory,
        StatusInterface $status,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.factory_status')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($status);

        $status->setDescription(Argument::type('string'))->shouldBeCalled()->willReturn($status);

        $manager->persist($status)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_0_order()
    {
        $this->getOrder()->shouldReturn(0);
    }
}
