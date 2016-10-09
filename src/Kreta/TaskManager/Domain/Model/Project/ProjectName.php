<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project;

class ProjectName
{
    public function __construct(string $name)
    {
        if ('' === $name) {
            throw new ProjectNameEmptyException();
        }
        $this->name = $name;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function __toString() : string
    {
        return (string) $this->name;
    }
}
