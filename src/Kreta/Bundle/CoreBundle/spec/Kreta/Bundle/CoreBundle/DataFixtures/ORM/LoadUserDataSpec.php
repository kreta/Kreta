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
use Kreta\Component\Core\Factory\MediaFactory;
use Kreta\Component\Core\Model\Interfaces\MediaInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Uploader\Interfaces\MediaUploaderInterface;
use Prophecy\Argument;
use spec\Kreta\Bundle\CoreBundle\DataFixtures\DataFixturesSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserDataSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DataFixtures\ORM
 */
class LoadUserDataSpec extends DataFixturesSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\ORM\LoadUserData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        MediaUploaderInterface $uploader,
        MediaFactory $mediaFactory,
        MediaInterface $media,
        BaseFactory $factory,
        UserInterface $user,
        ObjectManager $manager
    )
    {
        $this->loadMedias(
            $container,
            $uploader,
            $mediaFactory,
            $media,
            $manager,
            'kreta_core.uploader.image_user'
        );

        $this->createUser($container, $factory, $user, 'ROLE_ADMIN');
        $user->setPhoto(Argument::type('Kreta\Component\Core\Model\Interfaces\MediaInterface'))
            ->shouldBeCalled()->willReturn($user);
        $manager->persist($user)->shouldBeCalled();

        $this->createUser($container, $factory, $user);
        $user->setPhoto(Argument::type('Kreta\Component\Core\Model\Interfaces\MediaInterface'))
            ->shouldBeCalled()->willReturn($user);
        $manager->persist($user)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_0_order()
    {
        $this->getOrder()->shouldReturn(0);
    }


    private function createUser(
        ContainerInterface $container,
        BaseFactory $factory,
        UserInterface $user,
        $role = 'ROLE_USER'
    )
    {
        $container->get('kreta_core.factory.user')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($user);

        $user->setFirstName(Argument::type('string'))->shouldBeCalled()->willReturn($user);
        $user->setLastName(Argument::type('string'))->shouldBeCalled()->willReturn($user);
        $user->setEmail(Argument::type('string'))->shouldBeCalled()->willReturn($user);
        $user->setPlainPassword(123456)->shouldBeCalled()->willReturn($user);
        $user->setRoles([$role])->shouldBeCalled()->willReturn($user);
        $user->setEnabled(true)->shouldBeCalled()->willReturn($user);
    }
}
