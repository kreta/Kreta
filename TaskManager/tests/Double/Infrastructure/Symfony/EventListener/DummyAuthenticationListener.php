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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class DummyAuthenticationListener
{
    private $tokenStorage;

    const USER_IDS = [
        'access-token-1' => 'da49c01f-2e99-45ee-9557-eb3eb57b06c5',
        'access-token-2' => '6704c278-e106-449f-a73d-2508e96f6177',
    ];

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(GetResponseEvent $event) : void
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();

        // Prevents to crash the Symfony profiler routes
        if (0 === mb_strpos($request->getPathInfo(), '/_')) {
            return;
        }

        $this->tokenStorage->getToken()->setUser(new User($this->userId($request)));
    }

    private function userId(Request $request) : ?string
    {
        if ($request->headers->has('Authorization')) {
            $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
        } elseif ($request->query->has('access_token')) {
            $token = $request->query->get('access_token');
        } else {
            throw new UnauthorizedHttpException('Basic');
        }

        return isset(self::USER_IDS[$token]) ? self::USER_IDS[$token] : null;
    }
}
