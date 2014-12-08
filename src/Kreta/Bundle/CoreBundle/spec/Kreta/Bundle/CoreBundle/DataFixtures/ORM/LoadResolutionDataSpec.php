<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\BaseFactory;
use Kreta\Component\Core\Model\Interfaces\ResolutionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadResolutionDataSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DataFixtures\ORM
 */
class LoadResolutionDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, ReferenceRepository $referenceRepository)
    {
        $this->setContainer($container);
        $this->setReferenceRepository($referenceRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\ORM\LoadResolutionData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        BaseFactory $factory,
        ResolutionInterface $resolution,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.factory.resolution')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($resolution);

        $resolution->setDescription(Argument::type('string'))->shouldBeCalled()->willReturn($resolution);

        $manager->persist($resolution)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_0_order()
    {
        $this->getOrder()->shouldReturn(0);
    }
}
