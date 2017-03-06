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

declare(strict_types=1);

namespace Spec\Kreta\IdentityAccess\Domain\Model\User;

use BenGorFile\File\Domain\Model\File;
use BenGorFile\File\Domain\Model\FileId;
use BenGorFile\File\Domain\Model\FileMimeType;
use BenGorFile\File\Domain\Model\FileMimeTypeDoesNotSupportException;
use BenGorFile\File\Domain\Model\FileName;
use Kreta\IdentityAccess\Domain\Model\User\Image;
use PhpSpec\ObjectBehavior;

class ImageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new FileId('image-id'),
            new FileName('image-name.png'),
            new FileMimeType('image/png')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Image::class);
        $this->shouldHaveType(File::class);
    }

    function it_cannot_create_a_file_that_does_not_be_an_image()
    {
        $this->beConstructedWith(
            new FileId('file-id'),
            new FileName('file.pdf'),
            new FileMimeType('application/pdf')
        );

        $this->shouldThrow(FileMimeTypeDoesNotSupportException::class)->duringInstantiation();
    }
}
