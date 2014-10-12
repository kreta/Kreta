<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserProviderSpec.
 *
 * @package spec\Kreta\CoreBundle\Security
 */
class UserProviderSpec extends ObjectBehavior
{
    function let(UserManagerInterface $userManager)
    {
        $this->beConstructedWith($userManager, array('bitbucket' => 'bitbucket_id', 'github' => 'github_id'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Security\UserProvider');
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
//        \Kreta\CoreBundle\Model\Interfaces\UserInterface $fosUser
//    )
//    {
//        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
//        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');
//
//        $response->getEmail()->shouldBeCalled()->willReturn('user@kreta.com');
//
//        $response->getResourceOwner()->shouldBeCalled()->willReturn($resourceOwner);
//        $resourceOwner->getName()->shouldBeCalled()->willReturn('github');
//
//        $userManager->findUserBy(array('github_id' => 'user@kreta.com'))->shouldBeCalled()->willReturn($fosUser);
//        $fosUser->setGithubId(null)->shouldBeCalled()->willReturn($fosUser);
//        $fosUser->setGithubAccessToken(null)->shouldBeCalled()->willReturn($fosUser);
//
//        $userManager->updateUser($fosUser)->shouldBeCalled();
//
//
////        $fosUser->setGithubId('user@kreta.com')->shouldBeCalled();
//
////        $response->getAccessToken()->shouldBeCalled()->willReturn('github-access-token');
////        $fosUser->setGithubAccessToken('github-access-token')->shouldBeCalled()->willReturn($fosUser);
////        $userManager->updateUser($user)->shouldBeCalled();
//
//        $this->connect($user, $response);
//    }
}
