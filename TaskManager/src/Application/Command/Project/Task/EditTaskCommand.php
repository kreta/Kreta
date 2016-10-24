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

namespace Kreta\TaskManager\Application\Command\Project\Task;

class EditTaskCommand
{
    private $id;
    private $title;
    private $description;
    private $editorId;

    public function __construct(string $id, string $title, string $description, string $editorId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->editorId = $editorId;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function editorId() : string
    {
        return $this->editorId;
    }
}
