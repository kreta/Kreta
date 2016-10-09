<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project;

class ProjectNameEmptyException extends \Exception
{
    public function __construct()
    {
        parent::__construct();
        $this->message = 'Project name must not be empty';
    }
}
