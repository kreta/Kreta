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

namespace Spec\Kreta\IdentityAccess\Application\Command;

use Kreta\IdentityAccess\Application\Command\EditProfileCommand;
use PhpSpec\ObjectBehavior;

class EditProfileCommandSpec extends ObjectBehavior
{
    function it_creates_a_command()
    {
        $this->beConstructedWith(
            'user-id',
            'user@user.net',
            'kreta-username',
            'kreta',
            'lastname',
            null,
            null,
            null
        );
        $this->shouldHaveType(EditProfileCommand::class);

        $this->id()->shouldReturn('user-id');
        $this->email()->shouldReturn('user@user.net');
        $this->username()->shouldReturn('kreta-username');
        $this->firstName()->shouldReturn('kreta');
        $this->lastName()->shouldReturn('lastname');
        $this->imageName()->shouldReturn(null);
        $this->imageMimeType()->shouldReturn(null);
        $this->uploadedImage()->shouldReturn(null);
    }

    function it_creates_a_command_with_image()
    {
        $this->beConstructedWith(
            'user-id',
            'user@user.net',
            'kreta-username',
            'kreta',
            'lastname',
            'image-name.png',
            'image/png',
            'image data content'
        );
        $this->shouldHaveType(EditProfileCommand::class);

        $this->id()->shouldReturn('user-id');
        $this->email()->shouldReturn('user@user.net');
        $this->username()->shouldReturn('kreta-username');
        $this->firstName()->shouldReturn('kreta');
        $this->lastName()->shouldReturn('lastname');
        $this->imageName()->shouldReturn('image-name.png');
        $this->imageMimeType()->shouldReturn('image/png');
        $this->uploadedImage()->shouldReturn('image data content');
    }
}
