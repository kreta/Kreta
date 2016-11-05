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
    private $name;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}
