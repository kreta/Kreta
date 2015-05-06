<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Util\Random;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class LoadOauthData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadOauthData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $client = $this->container->get('kreta_core.command.create_client')->generateClient(
            ['http://kreta.io'],
            ['authorization_code', 'password', 'refresh_token', 'token', 'client_credentials'],
            'dummy-client-secret'
        );

        $users = $this->container->get('kreta_user.repository.user')->findAll();

        foreach ($users as $user) {
            if ($user->getEmail() === 'kreta@kreta.com') {
                $this->generateAccessToken($client, $user);
                $this->generateRefreshToken($client, $user);
            } else {
                $this->generateAccessToken($client, $user, Random::generateToken(), time());
                $this->generateRefreshToken($client, $user, Random::generateToken(), time());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Generates the access token with client, associated user, token string and expires at given.
     *
     * @param \Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface $client    The client
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface      $user      The user
     * @param string                                                    $token     The token string
     * @param int|null                                                  $expiresAt The expires at, in integer format
     *
     * @return \FOS\OAuthServerBundle\Model\AccessTokenInterface
     */
    protected function generateAccessToken(
        ClientInterface $client,
        UserInterface $user,
        $token = 'dummy-access-token',
        $expiresAt = null
    )
    {
        return $this->generateToken($client, $user, 'access', $token, $expiresAt);
    }

    /**
     * Generates the refresh token with client, associated user, token string and expires at given.
     *
     * @param \Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface $client    The client
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface      $user      The user
     * @param string                                                    $token     The token string
     * @param int|null                                                  $expiresAt The expires at, in integer format
     *
     * @return \FOS\OAuthServerBundle\Model\RefreshTokenInterface
     */
    protected function generateRefreshToken(
        ClientInterface $client,
        UserInterface $user,
        $token = 'dummy-refresh-token',
        $expiresAt = null
    )
    {
        return $this->generateToken($client, $user, 'refresh', $token, $expiresAt);
    }

    /**
     * Generates the token with client, associated user, the class of token, token string and expires at given.
     *
     * @param \Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface $client      The client
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface      $user        The user
     * @param string                                                    $class       The class of token
     * @param string                                                    $tokenString The token string
     * @param int|null                                                  $expiresAt   The expires at, in integer format
     *
     * @return \FOS\OAuthServerBundle\Model\TokenInterface
     */
    private function generateToken(
        ClientInterface $client,
        UserInterface $user,
        $class,
        $tokenString = 'dummy-access-token',
        $expiresAt = null
    )
    {
        $manager = $this->container->get('fos_oauth_server.' . $class . '_token_manager.default');
        $token = $manager->createToken();
        $token->setClient($client);
        $token->setScope('user');
        $token->setToken($tokenString);
        $token->setExpiresAt($expiresAt);
        $token->setUser($user);
        $manager->updateToken($token);

        return $token;
    }
}
