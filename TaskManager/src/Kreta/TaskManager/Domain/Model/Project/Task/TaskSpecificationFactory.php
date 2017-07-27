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

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;

interface TaskSpecificationFactory
{
    public function buildFilterableSpecification(
        array $projectIds,
        ?string $title,
        ?TaskId $parentId,
        ?TaskPriority $priority,
        ?TaskProgress $progress,
        array $assigneeIds = [],
        array $creatorIds = [],
        int $offset = 0,
        int $limit = -1
    );

    public function buildByProjectSpecification(ProjectId $projectId, int $offset = 0, int $limit = -1);

    public function buildByAssigneeSpecification(MemberId $assigneeId, int $offset = 0, int $limit = -1);

    public function buildByCreatorSpecification(MemberId $creatorId, int $offset = 0, int $limit = -1);
}
