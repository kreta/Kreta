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

namespace Kreta\TaskManager\Application\Project\Task;

class ChangeTaskProgressCommand
{
    private $id;
    private $progress;
    private $editorId;

    public function __construct(
        string $id,
        string $progress,
        string $editorId
    ) {
        $this->id = $id;
        $this->progress = $progress;
        $this->editorId = $editorId;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function progress()
    {
        return $this->progress;
    }

    public function editorId()
    {
        return $this->editorId;
    }
}
