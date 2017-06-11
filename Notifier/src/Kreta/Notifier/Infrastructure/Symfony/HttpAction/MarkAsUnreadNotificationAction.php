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

use Kreta\Notifier\Application\Inbox\Notification\MarkAsUnreadNotificationCommand;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\SharedKernel\Application\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class MarkAsUnreadNotificationAction
{
    private $commandBus;
    private $userId;

    public function __construct(TokenStorageInterface $tokenStorage, CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        $this->userId = $tokenStorage->getToken()->getUser()->getUsername();
    }

    public function __invoke(string $notificationId) : JsonResponse
    {
        try {
            $this->commandBus->handle(
                new MarkAsUnreadNotificationCommand(
                    $notificationId,
                    $this->userId
                )
            );
        } catch (UserDoesNotExist | NotificationDoesNotExist $exception) {
            return new JsonResponse(null, 404);
        }

        return new JsonResponse();
    }
}
