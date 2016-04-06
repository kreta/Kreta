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

namespace Kreta\Bundle\UserBundle\Exception;

use OAuth2\OAuth2;
use OAuth2\OAuth2AuthenticateException;

/**
 * Wrapper of FOSOAuthServerBundle's OAuth2AuthenticateException
 * with Unauthorized http code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UnauthorizedException extends OAuth2AuthenticateException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param OAuth2 $oauth2  The OAuth2
     * @param string $message The message
     */
    public function __construct(OAuth2 $oauth2, $message)
    {
        parent::__construct(
            OAuth2::HTTP_UNAUTHORIZED,
            OAuth2::TOKEN_TYPE_BEARER,
            $oauth2->getVariable(OAuth2::CONFIG_WWW_REALM),
            'access_denied',
            $message
        );
    }
}
