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

class ChangeParentTaskCommand
{
    private $id;
    private $changerId;
    private $parentId;

    public function __construct(string $id, string $changerId, string $parentId = null)
    {
        $this->id = $id;
        $this->changerId = $changerId;
        $this->parentId = $parentId;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function changerId() : string
    {
        return $this->changerId;
    }

    public function parentId()
    {
        return $this->parentId;
    }
}
