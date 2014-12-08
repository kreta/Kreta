<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\MediaFactory;
use Kreta\Component\Core\Model\Interfaces\MediaInterface;
use Kreta\Component\Core\Uploader\Interfaces\MediaUploaderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DataFixturesSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DataFixtures
 */
class DataFixturesSpec extends ObjectBehavior
{
    protected function loadMedias(
        ContainerInterface $container,
        MediaUploaderInterface $uploader,
        MediaFactory $mediaFactory,
        MediaInterface $media,
        ObjectManager $manager,
        $uploaderService
    )
    {
        $container->get($uploaderService)->shouldBeCalled()->willReturn($uploader);
        $container->get('kreta_core.factory.media')->shouldBeCalled()->willReturn($mediaFactory);
        $mediaFactory->create(Argument::type('Symfony\Component\HttpFoundation\File\UploadedFile'))
            ->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();

        $manager->persist($media)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();
    }
}
