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

namespace Kreta\TaskManager\Application\Query\Organization;

class CountOrganizationsQuery
{
    private $userId;
    private $name;

    public function __construct(string $userId, string $name = null)
    {
        $this->userId = $userId;
        $this->name = $name;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function name()
    {
        return $this->name;
    }
}
