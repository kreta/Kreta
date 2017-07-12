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

namespace Kreta\Notifier\Domain\Model\Inbox\Notification;

class NotificationType
{
    private $type;

    public function __construct(string $type)
    {
        $this->setType($type);
    }

    private function setType(string $type) : void
    {
        $this->checkTypeIsValid($type);
        $this->type = $type;
    }

    private function checkTypeIsValid(string $type) : void
    {
        if (!in_array($type, $this->availableTypes(), true)) {
            throw new NotificationTypeIsNotValid($type);
        }
    }

    private function availableTypes() : array
    {
        return [
            'project_created',
            'project_edited',
            'task_created',
            'task_edited',
        ];
    }

    public function type() : string
    {
        return $this->type;
    }

    public function __toString() : string
    {
        return (string) $this->type();
    }
}
