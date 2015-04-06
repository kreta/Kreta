<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Media\Uploader;

use Gaufrette\Filesystem;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaUploaderSpec.
 *
 * @package spec\Kreta\Component\Media\Uploader
 */
class MediaUploaderSpec extends ObjectBehavior
{
    function let(UploadedFile $file, Filesystem $filesystem)
    {
        $file->beConstructedWith([__DIR__ . '/../../../../../README.md']);

        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Media\Uploader\MediaUploader');
    }

    function it_implements_media_uploader_interface()
    {
        $this->shouldImplement('Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface');
    }

    function it_does_not_upload_because_media_object_has_not_media(MediaInterface $media)
    {
        $media->hasMedia()->shouldBeCalled()->willReturn(false);

        $this->upload($media);
    }

    function it_uploads_removing_existing_media(MediaInterface $media, Filesystem $filesystem, UploadedFile $file)
    {
        $media->hasMedia()->shouldBeCalled()->willReturn(true);

        $media->getName()->shouldBeCalled()->willReturn('media-name');
        $filesystem->delete('media-name')->shouldBeCalled()->willReturn(true);

        $media->getMedia()->shouldBeCalled()->willReturn($file);
        $file->guessExtension()->shouldBeCalled()->willReturn('md');
        $filesystem->has(Argument::containingString('.md'))->shouldBeCalled()->willReturn(false);

        $media->setName(Argument::type('string'))->shouldBeCalled()->willReturn($media);

        $media->getMedia()->shouldBeCalled()->willReturn($file);
        $file->getPathname()->shouldBeCalled()->willReturn(__DIR__ . '/../../../../../README.md');
        $filesystem->write(Argument::type('string'), file_get_contents(__DIR__ . '/../../../../../README.md'))
            ->shouldBeCalled()->willReturn(Argument::type('int'));

        $this->upload($media);
    }

    function it_uploads_without_removing(MediaInterface $media, Filesystem $filesystem, UploadedFile $file)
    {
        $media->hasMedia()->shouldBeCalled()->willReturn(true);

        $media->getName()->shouldBeCalled()->willReturn(null);

        $media->getMedia()->shouldBeCalled()->willReturn($file);
        $file->guessExtension()->shouldBeCalled()->willReturn('md');
        $filesystem->has(Argument::containingString('.md'))->shouldBeCalled()->willReturn(false);

        $media->setName(Argument::any())->shouldBeCalled()->willReturn($media);

        $media->getMedia()->shouldBeCalled()->willReturn($file);
        $file->getPathname()->shouldBeCalled()->willReturn(__DIR__ . '/../../../../../README.md');
        $filesystem->write(Argument::any(), file_get_contents(__DIR__ . '/../../../../../README.md'))
            ->shouldBeCalled()->willReturn(Argument::type('int'));

        $this->upload($media);
    }

    function it_removes(Filesystem $filesystem)
    {
        $filesystem->delete('media-name')->shouldBeCalled()->willReturn(true);

        $this->remove('media-name')->shouldReturn(true);
    }

    function it_does_not_remove(Filesystem $filesystem)
    {
        $filesystem->delete('media-name')->shouldBeCalled()->willReturn(false);

        $this->remove('media-name')->shouldReturn(false);
    }
}
