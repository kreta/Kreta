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

namespace Spec\Kreta\IdentityAccess\Application\DataTransformer;

use BenGorFile\File\Domain\Model\FileName;
use BenGorUser\User\Application\DataTransformer\UserDataTransformer;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Kreta\IdentityAccess\Application\DataTransformer\UserPublicDTODataTransformer;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\Image;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use PhpSpec\ObjectBehavior;

class UserPublicDTODataTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserPublicDTODataTransformer::class);
    }

    function it_implements_user_data_transformer()
    {
        $this->shouldImplement(UserDataTransformer::class);
    }

    function it_transforms(
        User $user,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $lastLogin,
        \DateTimeImmutable $updatedOn,
        FullName $fullName,
        Username $username,
        Image $image
    ) {
        $this->read()->shouldReturn([]);

        $this->write($user);

        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $user->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $user->email()->shouldBeCalled()->willReturn(new UserEmail('user@user.com'));
        $user->lastLogin()->shouldBeCalled()->willReturn($lastLogin);
        $user->updatedOn()->shouldBeCalled()->willReturn($updatedOn);

        $user->username()->shouldBeCalled()->willReturn($username);
        $username->username()->shouldBeCalled()->willReturn('user11111');

        $user->fullName()->shouldBeCalled()->willReturn($fullName);
        $fullName->firstName()->shouldBeCalled()->willReturn('The user first name');
        $fullName->lastName()->shouldBeCalled()->willReturn('The user last name');
        $fullName->fullName()->shouldBeCalled()->willReturn('The user first name The user last name');

        $user->image()->shouldBeCalled()->willReturn($image);
        $imageName = new FileName('image-name.png');
        $image->name()->shouldBeCalled()->willReturn($imageName);

        $this->read()->shouldReturn([
            'id'                      => 'user-id',
            'user_id'                 => 'user-id',
            'created_on'              => $createdOn,
            'email'                   => 'user@user.com',
            'first_name'              => 'The user first name',
            'full_name'               => 'The user first name The user last name',
            'last_login'              => $lastLogin,
            'last_name'               => 'The user last name',
            'image'                   => '/image-name.png',
            'updated_on'              => $updatedOn,
            'user_name'               => 'user11111',
        ]);
    }

    function it_transforms_with_other_upload_destination(
        User $user,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $lastLogin,
        \DateTimeImmutable $updatedOn,
        FullName $fullName,
        Username $username,
        Image $image
    ) {
        $this->beConstructedWith('/other-upload-destination');

        $this->read()->shouldReturn([]);

        $this->write($user);

        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $user->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $user->email()->shouldBeCalled()->willReturn(new UserEmail('user@user.com'));
        $user->lastLogin()->shouldBeCalled()->willReturn($lastLogin);
        $user->updatedOn()->shouldBeCalled()->willReturn($updatedOn);

        $user->username()->shouldBeCalled()->willReturn($username);
        $username->username()->shouldBeCalled()->willReturn('user11111');

        $user->fullName()->shouldBeCalled()->willReturn($fullName);
        $fullName->firstName()->shouldBeCalled()->willReturn('The user first name');
        $fullName->lastName()->shouldBeCalled()->willReturn('The user last name');
        $fullName->fullName()->shouldBeCalled()->willReturn('The user first name The user last name');

        $user->image()->shouldBeCalled()->willReturn($image);
        $imageName = new FileName('image-name.png');
        $image->name()->shouldBeCalled()->willReturn($imageName);

        $this->read()->shouldReturn([
            'id'                      => 'user-id',
            'user_id'                 => 'user-id',
            'created_on'              => $createdOn,
            'email'                   => 'user@user.com',
            'first_name'              => 'The user first name',
            'full_name'               => 'The user first name The user last name',
            'last_login'              => $lastLogin,
            'last_name'               => 'The user last name',
            'image'                   => '/other-upload-destination/image-name.png',
            'updated_on'              => $updatedOn,
            'user_name'               => 'user11111',
        ]);
    }
}
