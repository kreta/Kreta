<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Model\TokenInterface;
use FOS\OAuthServerBundle\Model\TokenManagerInterface;
use Kreta\Bundle\CoreBundle\Command\CreateClientCommand;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadOauthDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadOauthDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, ReferenceRepository $referenceRepository)
    {
        $this->setContainer($container);
        $this->setReferenceRepository($referenceRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadOauthData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        CreateClientCommand $createClientCommand,
        ClientInterface $client,
        UserRepository $userRepository,
        UserInterface $user,
        UserInterface $user2,
        TokenManagerInterface $tokenManager,
        TokenInterface $token,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.command.create_client')
            ->shouldBeCalled()->willReturn($createClientCommand);
        $createClientCommand->generateClient(
            ['http://kreta.io'], ['authorization_code', 'password', 'refresh_token', 'token', 'client_credentials']
        )->shouldBeCalled()->willReturn($client);

        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user, $user2]);

        $user->getEmail()->shouldBeCalled()->willReturn('kreta@kreta.com');
        $this->generateToken(
            'dummy-access-token',
            'access',
            $container,
            $tokenManager,
            $token,
            $client,
            $user
        );
        $this->generateToken(
            'dummy-refresh-token',
            'refresh',
            $container,
            $tokenManager,
            $token,
            $client,
            $user
        );

        $user2->getEmail()->shouldBeCalled()->willReturn(Argument::not('kreta@kreta.com'));
        $this->generateToken(
            Argument::type('string'),
            'access',
            $container,
            $tokenManager,
            $token,
            $client,
            $user2,
            Argument::not(null)
        );
        $this->generateToken(
            Argument::type('string'),
            'refresh',
            $container,
            $tokenManager,
            $token,
            $client,
            $user2,
            Argument::not(null)
        );

        $this->load($manager);
    }

    function it_gets_1_order()
    {
        $this->getOrder()->shouldReturn(1);
    }

    private function generateToken(
        $tokenString,
        $class,
        ContainerInterface $container,
        TokenManagerInterface $tokenManager,
        TokenInterface $token,
        ClientInterface $client,
        UserInterface $user,
        $expiresAt = null
    )
    {
        $container->get('fos_oauth_server.' . $class . '_token_manager.default')
            ->shouldBeCalled()->willReturn($tokenManager);
        $tokenManager->createToken()->shouldBeCalled()->willReturn($token);
        $token->setClient($client)->shouldBeCalled();
        $token->setScope('user')->shouldBeCalled();
        $token->setToken($tokenString)->shouldBeCalled();
        $token->setExpiresAt($expiresAt)->shouldBeCalled();
        $token->setUser($user)->shouldBeCalled();
        $tokenManager->updateToken($token)->shouldBeCalled();
    }
}
