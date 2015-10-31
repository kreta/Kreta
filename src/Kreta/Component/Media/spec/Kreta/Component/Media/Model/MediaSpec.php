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

namespace spec\Kreta\Component\Media\Model;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaSpec.
 *
 * @package spec\Kreta\Component\Media\Model
 */
class MediaSpec extends ObjectBehavior
{
    function let(UploadedFile $media)
    {
        $media->beConstructedWith([__DIR__ . '/../../../../../README.md']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Media\Model\Media');
    }

    function it_implements_media_interface()
    {
        $this->shouldImplement('Kreta\Component\Media\Model\Interfaces\MediaInterface');
    }

    function its_created_at_is_datetime()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
    }

    function its_media_is_mutable(UploadedFile $media)
    {
        $this->hasMedia()->shouldReturn(false);
        $this->setMedia($media)->shouldReturn($this);
        $this->getMedia()->shouldReturn($media);
        $this->hasMedia()->shouldReturn(true);
    }

    function its_name_is_mutable()
    {
        $this->setName('file-name')->shouldReturn($this);
        $this->getName()->shouldReturn('file-name');
    }

    function it_updated_at_is_mutable()
    {
        $updateDate = new \DateTime();

        $this->setUpdatedAt($updateDate)->shouldReturn($this);
        $this->getUpdatedAt()->shouldReturn($updateDate);
    }
}
