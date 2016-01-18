<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Component\Media\Factory;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
