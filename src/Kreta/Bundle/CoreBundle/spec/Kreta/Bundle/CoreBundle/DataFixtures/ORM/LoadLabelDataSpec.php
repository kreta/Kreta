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

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\BaseFactory;
use Kreta\Component\Core\Model\Interfaces\LabelInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadLabelDataSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DataFixtures\ORM
 */
class LoadLabelDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\ORM\LoadLabelData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        BaseFactory $factory,
        LabelInterface $label,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.factory_label')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($label);

        $label->setName(Argument::type('string'))->shouldBeCalled()->willReturn($label);

        $manager->persist($label)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_0_order()
    {
        $this->getOrder()->shouldReturn(0);
    }
}
