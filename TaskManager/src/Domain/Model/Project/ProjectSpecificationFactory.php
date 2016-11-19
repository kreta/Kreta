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

namespace Kreta\TaskManager\Domain\Model\Project;

use Kreta\TaskManager\Domain\Model\User\UserId;

interface ProjectSpecificationFactory
{
    public function buildNameFilterableSpecification(UserId $userId, ProjectName $name = null, int $offset = 0, int $limit = -1);
}
