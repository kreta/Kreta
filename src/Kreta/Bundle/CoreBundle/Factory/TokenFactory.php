<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Factory;

use FOS\OAuthServerBundle\Model\TokenManagerInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class TokenFactory.
 *
 * @package Kreta\Bundle\CoreBundle\Factory
 */
class TokenFactory
{
    /**
     * The token manager.
     *
     * @var \FOS\OAuthServerBundle\Model\TokenManagerInterface
     */
    protected $tokenManager;

    /**
     * Constructor.
     *
     * @param \FOS\OAuthServerBundle\Model\TokenManagerInterface $tokenManager The token manager
     */
    public function __construct(TokenManagerInterface $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ClientInterface $client, UserInterface $user, $tokenString, $expiresAt = null)
    {
        $token = $this->tokenManager->createToken();
        $token->setClient($client);
        $token->setScope('user');
        $token->setToken($tokenString);
        $token->setExpiresAt($expiresAt);
        $token->setUser($user);

        $this->tokenManager->updateToken($token);

        return $token;
    }
}
