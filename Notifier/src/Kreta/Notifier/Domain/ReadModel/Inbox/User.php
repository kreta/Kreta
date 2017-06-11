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

namespace Kreta\Notifier\Domain\ReadModel\Inbox;

class User implements \JsonSerializable
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromArray(array $userData) : self
    {
        return new self($userData['id']);
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
        ];
    }
}
