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

namespace Kreta\TaskManager\Application\Query\Project;

class ProjectOfIdQuery
{
    private $projectId;
    private $userId;

    public function __construct(string $projectId, string $userId)
    {
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    public function projectId() : string
    {
        return $this->projectId;
    }

    public function userId() : string
    {
        return $this->userId;
    }
}
