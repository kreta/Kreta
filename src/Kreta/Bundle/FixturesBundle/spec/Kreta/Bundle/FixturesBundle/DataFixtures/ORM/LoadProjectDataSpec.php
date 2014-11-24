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

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\MediaFactory;
use Kreta\Component\Core\Factory\ProjectFactory;
use Kreta\Component\Core\Model\Interfaces\MediaInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Uploader\Interfaces\MediaUploaderInterface;
use Prophecy\Argument;
use spec\Kreta\Bundle\FixturesBundle\DataFixtures\DataFixturesSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadProjectDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadProjectDataSpec extends DataFixturesSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadProjectData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        MediaUploaderInterface $uploader,
        MediaFactory $mediaFactory,
        MediaInterface $media,
        ProjectFactory $factory,
        ProjectInterface $project,
        ObjectManager $manager
    )
    {
        $this->loadMedias(
            $container,
            $uploader,
            $mediaFactory,
            $media,
            $manager,
            'kreta_core.image_projects_uploader'
        );

        $container->get('kreta_core.factory_project')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($project);

        $project->setName(Argument::type('string'))->shouldBeCalled()->willReturn($project);
        $project->setShortName(Argument::type('string'))->shouldBeCalled()->willReturn($project);
        $project->setImage(Argument::type('Kreta\Component\Core\Model\Interfaces\MediaInterface'))
            ->shouldBeCalled()->willReturn($project);

        $manager->persist($project)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_1_order()
    {
        $this->getOrder()->shouldReturn(1);
    }
}
