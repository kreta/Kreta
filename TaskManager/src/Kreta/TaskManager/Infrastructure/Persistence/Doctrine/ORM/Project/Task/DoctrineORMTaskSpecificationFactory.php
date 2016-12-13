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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Project\Task;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;

class DoctrineORMTaskSpecificationFactory implements TaskSpecificationFactory
{
    public function buildFilterableSpecification(
        array $projectIds,
        $title,
        ? TaskId $parentId,
        ? TaskPriority $priority,
        ? TaskProgress $progress,
        int $offset = 0,
        int $limit = -1
    ) {
        if (empty($projectIds)) {
            throw new Exception('Needs at least one project id');
        }

        return new DoctrineORMFilterableSpecification(
            $projectIds,
            $title,
            $parentId,
            $priority,
            $progress,
            $offset,
            $limit
        );
    }
}
