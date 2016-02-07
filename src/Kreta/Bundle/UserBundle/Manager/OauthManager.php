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

namespace Kreta\Bundle\UserBundle\Manager;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\RefreshTokenInterface;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;

/**
 * Oauth manager class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OauthManager
{
    /**
     * The client manager.
     *
     * @var \FOS\OAuthServerBundle\Model\ClientManagerInterface
     */
    protected $clientManager;

    /**
     * The client secret.
     *
     * @var string|null
     */
    protected $clientSecret;

    /**
     * The instance of OAuth server.
     *
     * @var \OAuth2\OAuth2
     */
    protected $oauthServer;

    /**
     * Constructor.
     *
     * @param \FOS\OAuthServerBundle\Model\ClientManagerInterface $clientManager The client manager
     * @param \OAuth2\OAuth2                                      $oauthServer   The instance of OAuth server
     * @param string|null                                         $clientSecret  The client secret
     */
    public function __construct(ClientManagerInterface $clientManager, OAuth2 $oauthServer, $clientSecret = null)
    {
        $this->clientManager = $clientManager;
        $this->oauthServer = $oauthServer;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Executes the "password" grant type.
     *
     * @param string $username The username
     * @param string $password The password
     *
     * @return array
     */
    public function password($username, $password)
    {
        return $this->grantType(OAuth2::GRANT_TYPE_USER_CREDENTIALS, [
            'username' => $username,
            'password' => $password,
        ]);
    }

    /**
     * Executes the "refresh token" grant type.
     *
     * @param RefreshTokenInterface $refreshToken The refresh token
     *
     * @return array
     */
    public function refreshToken(RefreshTokenInterface $refreshToken)
    {
        return $this->grantType(OAuth2::GRANT_TYPE_REFRESH_TOKEN, [
            'refresh_token' => $refreshToken->getToken(),
        ]);
    }

    /**
     * Scaffold method to use a OAuth gran type.
     *
     * @param string $name    The grant type
     * @param array  $options Array which contains the grant type custom options
     *
     * @return array
     * @throws \OAuth2\OAuth2ServerException
     */
    protected function grantType($name, array $options = [])
    {
        $client = $this->getClient();

        $request = new Request();
        $request->query->add(array_merge([
            'grant_type'    => $name,
            'client_secret' => $this->clientSecret,
            'client_id'     => sprintf('%s_%s', $client->getId(), $client->getRandomId()),
        ], $options));

        $response = $this->oauthServer->grantAccessToken($request);
        $token = json_decode($response->getContent(), true);

        return [$token['access_token'], $token['refresh_token']];
    }

    /**
     * Get the OAuth client.
     *
     * @return \FOS\OAuthServerBundle\Model\ClientInterface
     */
    protected function getClient()
    {
        return $this->clientManager->findClientBy(['secret' => $this->clientSecret]);
    }
}
