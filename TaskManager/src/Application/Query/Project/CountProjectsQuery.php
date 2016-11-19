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

class CountProjectsQuery
{
    private $userId;
    private $name;
    private $organizationId;

    public function __construct(string $userId, string $organizationId = null, string $name = null)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->organizationId = $organizationId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function organizationId()
    {
        return $this->organizationId;
    }

    public function name()
    {
        return $this->name;
    }
}
