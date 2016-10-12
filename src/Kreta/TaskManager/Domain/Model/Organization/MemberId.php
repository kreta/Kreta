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

namespace Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Identity\InvalidIdException;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Kreta\TaskManager\Domain\Model\User\UserId;

class MemberId
{
    protected $id;
    protected $userId;

    public static function generate(UserId $userId, $id = null)
    {
        return new static($userId, $id);
    }

    protected function __construct(UserId $userId, $id = null)
    {
        if ($id !== null && !is_scalar($id)) {
            throw new InvalidIdException();
        }
        $this->userId = $userId;
        $this->id = null === $id ? Uuid::generate() : $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function equals(MemberId $id) : bool
    {
        return $this->id === $id->id() && $this->userId->id() === $id->userId()->id();
    }

    public function __toString() : string
    {
        return 'Id: ' . (string) $this->id . ', UserId: ' . (string) $this->userId->id();
    }
}
