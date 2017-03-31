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

declare(strict_types=1);

namespace Kreta\TaskManager\Tests\Double\Infrastructure\Symfony\EventListener;

use Kreta\TaskManager\Infrastructure\Symfony\Security\User;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class DummyAuthenticationListener
{
    private $tokenStorage;

    const USER_ID = 'da49c01f-2e99-45ee-9557-eb3eb57b06c5';

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        // Prevents to crash the Symfony profiler routes
        if (0 === mb_strpos($event->getRequest()->getPathInfo(), '/_')) {
            return;
        }

        $this->tokenStorage->getToken()->setUser(new User(self::USER_ID));
    }
}
