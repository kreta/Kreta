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

namespace Kreta\Notifier\Application;

class GetDomainEventsQuery
{
    private $page;
    private $pageSize;
    private $since;

    public function __construct(int $page, int $pageSize, string $since = null)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->since = null === $since ? null : new \DateTimeImmutable($since);
    }

    public function page() : int
    {
        return $this->page;
    }

    public function pageSize() : int
    {
        return $this->pageSize;
    }

    public function since() : ?\DateTimeImmutable
    {
        return $this->since;
    }
}
