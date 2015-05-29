<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\User\Factory;

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserFactorySpec.
 *
 * @package spec\Kreta\Component\User\Factory
 */
class UserFactorySpec extends ObjectBehavior
{
    function let(MediaFactory $mediaFactory, MediaUploaderInterface $uploader)
    {
        $this->beConstructedWith('Kreta\Component\User\Model\User', $mediaFactory, $uploader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Factory\UserFactory');
    }

    function it_creates_a_user(MediaFactory $mediaFactory, MediaInterface $photo, MediaUploaderInterface $uploader)
    {
        $mediaFactory->create(Argument::type('Symfony\Component\HttpFoundation\File\UploadedFile'))
            ->shouldBeCalled()->willReturn($photo);
        $uploader->upload($photo)->shouldBeCalled();

        $this->create('kreta@kreta.com', false)
            ->shouldReturnAnInstanceOf('Kreta\Component\User\Model\Interfaces\UserInterface');
    }
}
