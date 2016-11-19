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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Project;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class DoctrineORMProjectSpecificationFactory implements ProjectSpecificationFactory
{
    public function buildFilterableSpecification(
        UserId $userId,
        array $organizationIds,
        ProjectName $name = null,
        int $offset = 0,
        int $limit = -1
    ) {
        if (empty($organizationIds)) {
            throw new Exception('Needs at least one organization id');
        }
        return new DoctrineORMFilterableSpecification($userId, $organizationIds, $name, $offset, $limit);
    }
}
