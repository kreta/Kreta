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

namespace Kreta\Bundle\CoreBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class OauthContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class OauthContext extends WebApiContext
{
    use KernelDictionary;

    /**
     * Populates the database with a client and access tokens.
     *
     * @param \Behat\Gherkin\Node\TableNode $tokens The tokens
     *
     *
     * @Given /^the following tokens exist:$/
     */
    public function theFollowingTokensExist(TableNode $tokens)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        $clientId = isset($token['clientId']) ? $token['clientId'] : null;
        $client = $this->loadClient($clientId);

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
     * @param string|null $id The client id
     *
     * @return \Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface
     *
     * @Given /^the OAuth client is loaded$/
     */
    public function loadClient($id = null)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRandomId('random-id');
        $client->setRedirectUris(['http://kreta.io']);
        $client->setSecret('client-secret');
        $client->setAllowedGrantTypes(['password']);

        if (null !== $id) {
            $metadata = $this->getManager()->getClassMetaData(get_class($client));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($client, ['id' => $id]);
        }
        $clientManager->updateClient($client);

        return $client;
    }
}
