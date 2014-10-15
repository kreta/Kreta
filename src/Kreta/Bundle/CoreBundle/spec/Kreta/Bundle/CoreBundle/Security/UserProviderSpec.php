<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface as KretaUser;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserProviderSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Security
 */
class UserProviderSpec extends ObjectBehavior
{
    function let(UserManagerInterface $userManager)
    {
        $this->beConstructedWith($userManager, array('bitbucket' => 'bitbucketId', 'github' => 'githubId'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Security\UserProvider');
    }

    function it_extends_fosub_user_provider()
    {
        $this->shouldHaveType('HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider');
    }

//    function it_connects(
//        UserInterface $user,
//        UserResponseInterface $response,
//        ResourceOwnerInterface $resourceOwner,
//        UserManagerInterface $userManager,
//        KretaUser $previousUser
//    )
//    {
//        $response->getEmail()->shouldBeCalled()->willReturn('user@kreta.com');
//
//        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
//        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');
//
//        $userManager->findUserBy(array('githubId' => 'user@kreta.com'))->shouldBeCalled()->willReturn($previousUser);
//        $previousUser->setUsername('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);
//        $previousUser->setEmail('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);
//        $previousUser->setGithubId(null)->shouldBeCalled()->willReturn($previousUser);
//        $previousUser->setGithubAccessToken(null)->shouldBeCalled()->willReturn($previousUser);
//        $userManager->updateUser($previousUser)->shouldBeCalled();
//
//        $response->getUsername()->shouldBeCalled()->willReturn('user@kreta.com');
//        $user->setGithubId('user@kreta.com')->shouldBeCalled()->willReturn($previousUser);
//
//        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
//        $user->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($previousUser);
//
//        $userManager->updateUser($user, true)->shouldBeCalled();
//
//        $this->connect($user, $response);
//    }
}
