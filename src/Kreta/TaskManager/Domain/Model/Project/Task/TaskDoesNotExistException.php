<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\Exception;

class TaskDoesNotExistException extends Exception
{
    public function __construct()
    {
        parent::__construct('The task does not exist');
    }
}
