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

namespace Kreta\IdentityAccess\Application\Query;

class UsersOfSearchStringQuery
{
    private $search;
    private $size;
    private $excludedIds;

    public function __construct(string $search, int $size, array $excludedIds = [])
    {
        $this->search = $search;
        $this->size = $size;
        $this->excludedIds = $excludedIds;
    }

    public function search() : string
    {
        return $this->search;
    }

    public function size() : int
    {
        return $this->size;
    }

    public function excludedIds() : array
    {
        return $this->excludedIds;
    }
}
