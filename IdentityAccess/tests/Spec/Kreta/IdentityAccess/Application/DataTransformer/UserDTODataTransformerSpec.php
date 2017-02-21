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

namespace Spec\Kreta\IdentityAccess\Application\DataTransformer;

use BenGorFile\File\Domain\Model\FileName;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserRole;
use Kreta\IdentityAccess\Application\DataTransformer\UserDTODataTransformer;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\Image;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use PhpSpec\ObjectBehavior;

class UserDTODataTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserDTODataTransformer::class);
    }

    function it_extends_bengor_user_user_dto_data_transformer()
    {
        $this->shouldHaveType(\BenGorUser\User\Application\DataTransformer\UserDTODataTransformer::class);
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

        $user->roles()->shouldBeCalled()->willReturn([new UserRole('ROLE_USER')]);

        $password = UserPassword::fromEncoded('encoded-password', 'user-password-salt');

        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $user->confirmationToken()->shouldBeCalled()->willReturn(null);
        $user->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $user->email()->shouldBeCalled()->willReturn(new UserEmail('user@user.com'));
        $user->invitationToken()->shouldBeCalled()->willReturn(null);
        $user->lastLogin()->shouldBeCalled()->willReturn($lastLogin);
        $user->password()->shouldBeCalled()->willReturn($password);
        $user->rememberPasswordToken()->shouldBeCalled()->willReturn(null);
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
            'confirmation_token'      => null,
            'created_on'              => $createdOn,
            'email'                   => 'user@user.com',
            'invitation_token'        => null,
            'last_login'              => $lastLogin,
            'encoded_password'        => 'encoded-password',
            'salt'                    => 'user-password-salt',
            'remember_password_token' => null,
            'roles'                   => ['ROLE_USER'],
            'updated_on'              => $updatedOn,
            'user_id'                 => 'user-id',
            'user_name'               => 'user11111',
            'first_name'              => 'The user first name',
            'last_name'               => 'The user last name',
            'full_name'               => 'The user first name The user last name',
            'image'                   => '/image-name.png',
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

        $user->roles()->shouldBeCalled()->willReturn([new UserRole('ROLE_USER')]);

        $password = UserPassword::fromEncoded('encoded-password', 'user-password-salt');

        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $user->confirmationToken()->shouldBeCalled()->willReturn(null);
        $user->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $user->email()->shouldBeCalled()->willReturn(new UserEmail('user@user.com'));
        $user->invitationToken()->shouldBeCalled()->willReturn(null);
        $user->lastLogin()->shouldBeCalled()->willReturn($lastLogin);
        $user->password()->shouldBeCalled()->willReturn($password);
        $user->rememberPasswordToken()->shouldBeCalled()->willReturn(null);
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
            'confirmation_token'      => null,
            'created_on'              => $createdOn,
            'email'                   => 'user@user.com',
            'invitation_token'        => null,
            'last_login'              => $lastLogin,
            'encoded_password'        => 'encoded-password',
            'salt'                    => 'user-password-salt',
            'remember_password_token' => null,
            'roles'                   => ['ROLE_USER'],
            'updated_on'              => $updatedOn,
            'user_id'                 => 'user-id',
            'user_name'               => 'user11111',
            'first_name'              => 'The user first name',
            'last_name'               => 'The user last name',
            'full_name'               => 'The user first name The user last name',
            'image'                   => '/other-upload-destination/image-name.png',
        ]);
    }
}
