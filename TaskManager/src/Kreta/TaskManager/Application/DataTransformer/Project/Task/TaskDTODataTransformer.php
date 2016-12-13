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

namespace Kreta\TaskManager\Application\DataTransformer\Project\Task;

use Kreta\TaskManager\Domain\Model\Project\Task\Task;

class TaskDTODataTransformer implements TaskDataTransformer
{
    private $task;

    public function write(Task $task)
    {
        $this->task = $task;
    }

    public function read()
    {
        if (!$this->task instanceof Task) {
            return [];
        }

        return [
            'id'          => $this->task->id()->id(),
            'title'       => $this->task->title()->title(),
            'priority'    => $this->task->priority()->priority(),
            'progress'    => $this->task->progress()->progress(),
            'description' => $this->task->description(),
            'created_on'  => $this->task->createdOn()->format('Y-m-d'),
            'updated_on'  => $this->task->updatedOn()->format('Y-m-d'),
            'project_id'  => $this->task->projectId()->id(),
            'parent_id'   => $this->task->parentId()->id(),
        ];
    }
}
