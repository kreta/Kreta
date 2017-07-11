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

namespace Kreta\Notifier\Infrastructure\Symfony\HttpAction;

use Kreta\Notifier\Application\Inbox\Notification\MarkAsReadNotificationCommand;
use Kreta\Notifier\Application\Inbox\Notification\ViewUserNotificationsQuery;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Application\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class MarkAllAsReadNotificationsAction
{
    private $commandBus;
    private $userId;
    private $queryBus;

    public function __construct(TokenStorageInterface $tokenStorage, CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->userId = $tokenStorage->getToken()->getUser()->getUsername();
        $this->queryBus = $queryBus;
    }

    public function __invoke() : JsonResponse
    {
        $this->queryBus->handle(
            new ViewUserNotificationsQuery(
                $this->userId,
                0,
                -1,
                'unread'
            ),
            $notifications
        );

        try {
            foreach ($notifications as $notification) {
                $this->commandBus->handle(
                    new MarkAsReadNotificationCommand(
                        $notification->id,
                        $this->userId
                    )
                );
            }
        } catch (UserDoesNotExist | NotificationDoesNotExist $exception) {
            return new JsonResponse(null, 404);
        }

        return new JsonResponse();
    }
}
