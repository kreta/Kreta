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

namespace Kreta\TaskManager\Infrastructure\Symfony\EventListener;

use Http\Client\HttpClient;
use Http\Message\Authentication\Bearer;
use Http\Message\MessageFactory;
use Kreta\TaskManager\Infrastructure\Symfony\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuthenticationListener
{
    private $messageFactory;
    private $client;
    private $tokenStorage;
    private $identityAccessHost;

    public function __construct(
        MessageFactory $messageFactory,
        HttpClient $client,
        TokenStorageInterface $tokenStorage,
        $identityAccessHost
    ) {
        $this->messageFactory = $messageFactory;
        $this->client = $client;
        $this->tokenStorage = $tokenStorage;
        $this->identityAccessHost = $identityAccessHost;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        // Prevents to crash the Symfony profiler routes
        if (0 === strpos($event->getRequest()->getPathInfo(), '/_')) {
            return;
        }

        $request = $this->messageFactory->createRequest('GET', '//' . $this->identityAccessHost . '/user');
        $request = $this->authentication($event->getRequest())->authenticate($request);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);
        if (!isset($data['user_id'])) {
            throw new UnauthorizedHttpException('Basic');
        }

        $this->tokenStorage->getToken()->setUser(new User($data['user_id']));
    }

    private function authentication(Request $request) : Bearer
    {
        if ($request->headers->has('Authorization')) {
            $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
        } elseif ($request->query->has('access_token')) {
            $token = $request->query->get('access_token');
        } else {
            throw new UnauthorizedHttpException('Basic');
        }

        return new Bearer($token);
    }
}
