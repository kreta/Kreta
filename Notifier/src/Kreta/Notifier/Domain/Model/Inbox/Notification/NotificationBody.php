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

class NotificationBody
{
    private $body;

    public function __construct(string $body)
    {
        if ('' === $body) {
            throw new NotificationBodyIsEmpty($body);
        }
        $this->body = $body;
    }

    public function body() : string
    {
        return $this->body;
    }

    public function __toString() : string
    {
        return (string) $this->body;
    }
}
