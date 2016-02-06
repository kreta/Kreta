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

namespace Kreta\Bundle\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Cookie event listener class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class CookieListener
{
    /**
     * Checks if the session has the tokens to
     * create cookies that will be add into response.
     *
     * @param FilterResponseEvent $event The cookie event
     */
    public function onCookieEvent(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->setCookie(
            $this->cookie('access_token', $event->getRequest()->getSession()->get('access_token'))
        );
    }

    /**
     * Creates cookie that its content is the given token.
     *
     * @param string $key   The name of token
     * @param string $value The value of token
     *
     * @return Cookie
     */
    private function cookie($key, $value)
    {
        return new Cookie($key, $value, 0, '/', null, false, false);
    }
}
