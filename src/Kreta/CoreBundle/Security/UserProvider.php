<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserProvider.
 *
 * @package Kreta\CoreBundle\Security
 */
class UserProvider extends BaseUserProvider
{
    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $email = $response->getEmail();

        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setterId = $setter . 'Id';
        $setterToken = $setter . 'AccessToken';

        $previousUser = $this->userManager->findUserBy(array($property => $email));
        if ($previousUser !== null) {
            $previousUser->setUsername($email);
            $previousUser->setEmail($email);
            $previousUser->$setterId(null);
            $previousUser->$setterToken(null);
            $this->userManager->updateUser($previousUser);
        }

        $user->$setterId($response->getUsername());
        $user->$setterToken($response->getAccessToken());

        $this->userManager->updateUser($user, true);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        if($response->getEmail() === '') {
            $user = $this->userManager->findUserBy(array($this->getProperty($response) => $response->getUsername()));
        } else {
            $user = $this->userManager->findUserBy(array('email' => $response->getEmail()));
        }

        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';

            $user = $this->userManager->createUser();

            $user->$setter_id($response->getUsername());
            $user->$setter_token($response->getAccessToken());
            $user->setEmail($response->getEmail());
            //Generate random password to avoid attacks.
            $user->setPassword(substr(md5(microtime()),rand(0,26),10));
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        $user->$setter($response->getAccessToken());

        return $user;
    }
}
