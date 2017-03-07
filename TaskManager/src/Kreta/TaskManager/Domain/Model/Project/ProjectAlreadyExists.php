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

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;

class ProjectAlreadyExists extends Exception
{
    public static function fromId(ProjectId $projectId)
    {
        return new self(
            sprintf(
                'Project with "%s" id already exists',
                $projectId->id()
            )
        );
    }

    public static function fromSlugs(Slug $slug, Slug $organizationSlug)
    {
        return new self(
            sprintf(
                'Project with "%s" slug and "%s" organization\'s slug already exists',
                $slug->slug(),
                $organizationSlug->slug()
            )
        );
    }
}
