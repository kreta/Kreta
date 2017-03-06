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

class ProjectOfSlugQuery
{
    private $slug;
    private $organizationSlug;
    private $userId;

    public function __construct(string $slug, string $organizationSlug, string $userId)
    {
        $this->slug = $slug;
        $this->organizationSlug = $organizationSlug;
        $this->userId = $userId;
    }

    public function slug() : string
    {
        return $this->slug;
    }

    public function organizationSlug() : string
    {
        return $this->organizationSlug;
    }

    public function userId() : string
    {
        return $this->userId;
    }
}
