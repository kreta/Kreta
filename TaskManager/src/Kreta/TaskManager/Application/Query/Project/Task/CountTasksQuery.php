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

class CountTasksQuery
{
    private $userId;
    private $title;
    private $projectId;

    public function __construct(string $userId, string $projectId = null, string $title = null)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->projectId = $projectId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function projectId() : ? string
    {
        return $this->projectId;
    }

    public function title() : ? string
    {
        return $this->title;
    }
}
