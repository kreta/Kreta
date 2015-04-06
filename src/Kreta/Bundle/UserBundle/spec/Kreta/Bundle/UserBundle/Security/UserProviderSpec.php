<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserProviderSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Security
 */
class UserProviderSpec extends ObjectBehavior
{
    function let(UserManagerInterface $userManager)
    {
        $this->beConstructedWith($userManager, ['bitbucket' => 'bitbucketId', 'github' => 'githubId']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Security\UserProvider');
    }

    function it_extends_fosub_user_provider()
    {
        $this->shouldHaveType('HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider');
    }

    function it_connects(
        UserInterface $user,
        UserResponseInterface $response,
        ResourceOwnerInterface $resourceOwner,
        UserManagerInterface $userManager,
        UserInterface $previousUser
    )
    {
        $response->getEmail()->shouldBeCalled()->willReturn('user@kreta.com');

        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');

        $userManager->findUserBy(['githubId' => 'user@kreta.com'])->shouldBeCalled()->willReturn($previousUser);
        $previousUser->setUsername('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);
        $previousUser->setEmail('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);
        $previousUser->setGithubId(null)->shouldBeCalled()->willReturn($previousUser);
        $previousUser->setGithubAccessToken(null)->shouldBeCalled()->willReturn($previousUser);
        $userManager->updateUser($previousUser, false)->shouldBeCalled();

        $response->getUsername()->shouldBeCalled()->willReturn('user@kreta.com');
        $user->setGithubId('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);

        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
        $user->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($previousUser);

        $userManager->updateUser($user)->shouldBeCalled();

        $this->connect($user, $response);
    }

    function it_loads_by_oauth_user_response_when_email_is_empty_and_user_is_not_exist(
        UserResponseInterface $response,
        UserManagerInterface $userManager,
        UserInterface $user,
        ResourceOwnerInterface $resourceOwner
    )
    {
        $response->getEmail()->shouldBeCalled()->willReturn('');
        $response->getUsername()->shouldBeCalled()->willReturn('user@kreta.com');
        $userManager->findUserBy(['githubId' => 'user@kreta.com'])->shouldBeCalled()->willReturn(null);

        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');

        $userManager->createUser()->shouldBeCalled()->willReturn($user);

        $response->getUsername()->shouldBeCalled()->willReturn('user@kreta.com');
        $user->setGithubId('user@kreta.com')->shouldBeCalled()->willReturn($user);
        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
        $user->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($user);
        $response->getEmail()->shouldBeCalled()->willReturn('');
        $user->setEmail('')->shouldBeCalled()->willReturn($user);
        $user->setPassword(Argument::type('string'))->shouldBeCalled()->willReturn($user);
        $user->setEnabled(true)->shouldBeCalled()->willReturn($user);
        $userManager->updateUser($user)->shouldBeCalled();

        $this->loadUserByOAuthUserResponse($response)->shouldReturn($user);
    }

    function it_loads_by_oauth_user_response_when_email_is_not_empty_but_user_does_not_exist(
        UserResponseInterface $response,
        UserManagerInterface $userManager,
        UserInterface $user,
        ResourceOwnerInterface $resourceOwner
    )
    {
        $response->getUsername()->shouldBeCalled()->willReturn('1234567');
        $userManager->findUserBy(['githubId' => '1234567'])->shouldBeCalled()->willReturn(null);

        $response->getEmail()->shouldBeCalled()->willReturn('kreta@kreta.com');
        $userManager->findUserBy(['email' => 'kreta@kreta.com'])->shouldBeCalled()->willReturn($user);

        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');

        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
        $user->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($user);

        $this->loadUserByOAuthUserResponse($response)->shouldReturn($user);
    }

    function it_loads_by_oauth_user_response_when_email_is_not_empty_and_user_exists(
        UserResponseInterface $response,
        UserManagerInterface $userManager,
        UserInterface $user,
        ResourceOwnerInterface $resourceOwner
    )
    {
        $response->getUsername()->shouldBeCalled()->willReturn('1234567');
        $userManager->findUserBy(['githubId' => '1234567'])->shouldBeCalled()->willReturn($user);

        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');

        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
        $user->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($user);

        $this->loadUserByOAuthUserResponse($response)->shouldReturn($user);
    }
}
