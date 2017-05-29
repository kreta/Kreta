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

namespace Kreta\Notifier\Domain\Model\Inbox;

class NotificationStatus
{
    private const READ = 'read';
    private const UNREAD = 'unread';

    private $status;

    public function __construct(string $status)
    {
        if ($status !== self::READ && $status !== self::UNREAD) {
            throw new NotificationStatusNotAllowed($status);
        }
        $this->status = $status;
    }

    public static function read()
    {
        return new self(self::READ);
    }

    public static function unread()
    {
        return new self(self::UNREAD);
    }

    public function status() : string
    {
        return $this->status;
    }

    public function __toString() : string
    {
        return (string) $this->status;
    }
}
