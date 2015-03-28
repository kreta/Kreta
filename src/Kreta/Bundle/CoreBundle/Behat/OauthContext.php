<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\WebApiExtension\Context\WebApiContext;

/**
 * Class OauthContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
 */
class OauthContext extends WebApiContext
{
    use KernelDictionary;

    /**
     * Populates the database with a client and access tokens.
     *
     * @param \Behat\Gherkin\Node\TableNode $tokens The tokens
     *
     * @return void
     *
     * @Given /^the following tokens exist:$/
     */
    public function theFollowingTokensExist(TableNode $tokens)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        $client = $this->getContainer()->get('kreta_core.command.create_client')
            ->generateClient(['http://kreta.io'], ['password']);

        $accessTokenManager = $this->getContainer()->get('fos_oauth_server.access_token_manager.default');
        foreach ($tokens as $token) {
            $accessToken = $accessTokenManager->createToken();
            $accessToken->setClient($client);
            $accessToken->setToken($token['token']);
            $accessToken->setExpiresAt($token['expiresAt']);
            $accessToken->setScope($token['scope']);

            $user = $this->getContainer()->get('kreta_user.repository.user')->findOneBy(['email' => $token['user']]);
            $accessToken->setUser($user);

            $manager->persist($accessToken);
        }

        $manager->flush();
    }

    /**
     * Adds OAuth2 Authentication header to next request.
     *
     * @param string $accessToken The access token
     *
     * @return void
     *
     * @Given /^I am authenticating with "([^"]*)" token/
     */
    public function iAmAuthenticatingWithToken($accessToken)
    {
        $this->removeHeader('Authorization');
        $this->addHeader('Authorization', 'Bearer ' . $accessToken);
    }

    /**
     * Loads OAuth2 client with hardcoded randomId and secret.
     *
     * @return void
     *
     * @Given /^the OAuth client is loaded$/
     */
    public function loadClient()
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRandomId('random-id');
        $client->setSecret('client-secret');
        $client->setAllowedGrantTypes(['password']);

        $clientManager->updateClient($client);
    }
}
