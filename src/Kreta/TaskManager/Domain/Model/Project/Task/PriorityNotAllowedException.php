<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

class PriorityNotAllowedException extends \Exception
{
    public function __construct(string $priority)
    {
        $this->message = sprintf(
            'Priority "%s" not allowed',
            $priority
        );
    }
}
