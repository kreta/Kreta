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

namespace Spec\Kreta\IdentityAccess\Application\Command;

use BenGorFile\File\Domain\Model\FileMimeType;
use BenGorFile\File\Domain\Model\FileName;
use BenGorFile\File\Domain\Model\Filesystem;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Kreta\IdentityAccess\Application\Command\EditProfileCommand;
use Kreta\IdentityAccess\Application\Command\EditProfileHandler;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\UserEmailAlreadyExistsException;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use Kreta\IdentityAccess\Domain\Model\User\UsernameAlreadyExistsException;
use Kreta\IdentityAccess\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditProfileHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $repository, Filesystem $filesystem)
    {
        $this->beConstructedWith($repository, $filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditProfileHandler::class);
    }

    function it_does_not_edit_profile_when_the_user_does_not_exist(
        EditProfileCommand $command,
        UserRepository $repository
    ) {
        $command->id()->shouldBeCalled()->willReturn('user-id');
        $command->email()->shouldBeCalled()->willReturn('user@user.net');
        $command->username()->shouldBeCalled()->willReturn('kreta-username');
        $command->firstName()->shouldBeCalled()->willReturn('kreta');
        $command->lastName()->shouldBeCalled()->willReturn('lastname');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_edit_profile_when_the_username_is_already_in_use(
        EditProfileCommand $command,
        UserRepository $repository,
        User $user,
        User $anotherUser
    ) {
        $command->id()->shouldBeCalled()->willReturn('user-id');
        $command->email()->shouldBeCalled()->willReturn('user@user.net');
        $command->username()->shouldBeCalled()->willReturn('kreta-username');
        $command->firstName()->shouldBeCalled()->willReturn('kreta');
        $command->lastName()->shouldBeCalled()->willReturn('lastname');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn($user);

        $repository->userOfUsername(new Username('kreta-username'))->shouldBeCalled()->willReturn($anotherUser);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser->id()->shouldBeCalled()->willReturn(new UserId('another-user-id'));

        $this->shouldThrow(UsernameAlreadyExistsException::class)->during__invoke($command);
    }

    function it_does_not_edit_profile_when_the_email_is_already_in_use(
        EditProfileCommand $command,
        UserRepository $repository,
        User $user,
        User $anotherUser,
        User $anotherUser2
    ) {
        $command->id()->shouldBeCalled()->willReturn('user-id');
        $command->email()->shouldBeCalled()->willReturn('user@user.net');
        $command->username()->shouldBeCalled()->willReturn('kreta-username');
        $command->firstName()->shouldBeCalled()->willReturn('kreta');
        $command->lastName()->shouldBeCalled()->willReturn('lastname');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn($user);

        $repository->userOfUsername(new Username('kreta-username'))->shouldBeCalled()->willReturn($anotherUser);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser->id()->shouldBeCalled()->willReturn(new UserId('user-id'));

        $repository->userOfEmail(new UserEmail('user@user.net'))->shouldBeCalled()->willReturn($anotherUser2);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser2->id()->shouldBeCalled()->willReturn(new UserId('another-user-id'));

        $this->shouldThrow(UserEmailAlreadyExistsException::class)->during__invoke($command);
    }

    function it_edits_profile(
        EditProfileCommand $command,
        UserRepository $repository,
        User $user,
        User $anotherUser,
        User $anotherUser2
    ) {
        $command->id()->shouldBeCalled()->willReturn('user-id');
        $command->email()->shouldBeCalled()->willReturn('user@user.net');
        $command->username()->shouldBeCalled()->willReturn('kreta-username');
        $command->firstName()->shouldBeCalled()->willReturn('kreta');
        $command->lastName()->shouldBeCalled()->willReturn('lastname');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn($user);

        $repository->userOfUsername(new Username('kreta-username'))->shouldBeCalled()->willReturn($anotherUser);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser->id()->shouldBeCalled()->willReturn(new UserId('user-id'));

        $repository->userOfEmail(new UserEmail('user@user.net'))->shouldBeCalled()->willReturn($anotherUser2);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser2->id()->shouldBeCalled()->willReturn(new UserId('user-id'));

        $user->editProfile(
            new UserEmail('user@user.net'),
            new Username('kreta-username'),
            new FullName('kreta', 'lastname')
        )->shouldBeCalled();

        $command->uploadedImage()->shouldBeCalled()->willReturn(null);

        $repository->persist($user)->shouldBeCalled();

        $this->__invoke($command);
    }

    function it_edits_profile_with_image(
        EditProfileCommand $command,
        UserRepository $repository,
        User $user,
        User $anotherUser,
        User $anotherUser2,
        Filesystem $filesystem
    ) {
        $command->id()->shouldBeCalled()->willReturn('user-id');
        $command->email()->shouldBeCalled()->willReturn('user@user.net');
        $command->username()->shouldBeCalled()->willReturn('kreta-username');
        $command->firstName()->shouldBeCalled()->willReturn('kreta');
        $command->lastName()->shouldBeCalled()->willReturn('lastname');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn($user);

        $repository->userOfUsername(new Username('kreta-username'))->shouldBeCalled()->willReturn($anotherUser);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser->id()->shouldBeCalled()->willReturn(new UserId('user-id'));

        $repository->userOfEmail(new UserEmail('user@user.net'))->shouldBeCalled()->willReturn($anotherUser2);
        $user->id()->shouldBeCalled()->willReturn(new UserId('user-id'));
        $anotherUser2->id()->shouldBeCalled()->willReturn(new UserId('user-id'));

        $user->editProfile(
            new UserEmail('user@user.net'),
            new Username('kreta-username'),
            new FullName('kreta', 'lastname')
        )->shouldBeCalled();

        $command->uploadedImage()->shouldBeCalled()->willReturn('image data content');

        $command->imageName()->shouldBeCalled()->willReturn('image-name.png');
        $command->imageMimeType()->shouldBeCalled()->willReturn('image/png');
        $mimeType = new FileMimeType('image/png');
        $filesystem->write(Argument::type(FileName::class), 'image data content')->shouldBeCalled();
        $user->uploadImage(Argument::type(FileName::class), $mimeType)->shouldBeCalled();

        $repository->persist($user)->shouldBeCalled();

        $this->__invoke($command);
    }
}
