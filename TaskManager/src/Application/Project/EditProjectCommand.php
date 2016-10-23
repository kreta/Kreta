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

namespace Kreta\TaskManager\Application\Project;

class EditProjectCommand
{
    private $id;
    private $name;
    private $slug;
    private $editorId;

    public function __construct(string $id, string $name, string $editorId, string $slug = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->editorId = $editorId;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function editorId() : string
    {
        return $this->editorId;
    }

    public function slug()
    {
        return $this->slug;
    }
}
