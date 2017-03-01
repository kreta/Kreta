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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;

interface ProjectSpecificationFactory
{
    public function buildFilterableSpecification(array $organizationIds, $name, int $offset = 0, int $limit = -1);

    public function buildBySlugSpecification(Slug $slug, Slug $organizationSlug);
}
