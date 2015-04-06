<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Media\Factory;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaFactorySpec.
 *
 * @package spec\Kreta\Component\Media\Factory
 */
class MediaFactorySpec extends ObjectBehavior
{
    function let(UploadedFile $file)
    {
        $file->beConstructedWith([__DIR__ . '/../../../../../README.md']);

        $this->beConstructedWith('Kreta\Component\Media\Model\Media');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Media\Factory\MediaFactory');
    }

    function it_creates_a_media(UploadedFile $file)
    {
        $this->create($file)->shouldReturnAnInstanceOf('Kreta\Component\Media\Model\Media');
    }
}
