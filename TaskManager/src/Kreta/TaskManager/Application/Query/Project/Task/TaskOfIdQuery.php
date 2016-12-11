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

namespace Kreta\TaskManager\Application\Query\Project\Task;

class TaskOfIdQuery
{
    private $taskId;
    private $userId;

    public function __construct(string $taskId, string $userId)
    {
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    public function taskId() : string
    {
        return $this->taskId;
    }

    public function userId() : string
    {
        return $this->userId;
    }
}
