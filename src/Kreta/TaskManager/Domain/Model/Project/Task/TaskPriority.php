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

namespace Kreta\TaskManager\Domain\Model\Project\Task;

class TaskPriority
{
    const LOW = 'low';
    const MEDIUM = 'medium';
    const HIGH = 'high';

    private $priority;

    private function __construct(string $priority)
    {
        $this->priority = $priority;
    }

    public static function low() : TaskPriority
    {
        return new self(self::LOW);
    }

    public static function medium() : TaskPriority
    {
        return new self(self::MEDIUM);
    }

    public static function high() : TaskPriority
    {
        return new self(self::HIGH);
    }

    public function priority() : string
    {
        return $this->priority;
    }

    public function __toString() : string
    {
        return $this->priority;
    }
}
