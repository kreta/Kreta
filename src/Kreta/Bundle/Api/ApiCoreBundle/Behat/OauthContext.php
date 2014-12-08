<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\WebApiExtension\Context\WebApiContext;

/**
 * Class OauthContext.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Behat
 */
class OauthContext extends WebApiContext implements Context, KernelAwareContext
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
        $container = $this->kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        $client = $container->get('kreta_api_core.command_createClientCommand')
            ->generateClient(['http://kreta.io'], ['password']);

        $accessTokenManager = $container->get('fos_oauth_server.access_token_manager.default');
        foreach ($tokens as $token) {
            $accessToken = $accessTokenManager->createToken();
            $accessToken->setClient($client);
            $accessToken->setToken($token['token']);
            $accessToken->setExpiresAt($token['expiresAt']);
            $accessToken->setScope($token['scope']);
            
            $user = $container->get('kreta_core.repository.user')->findOneBy(['email' => $token['user']]);
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
}
