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

use Kreta\SharedKernel\Event\EventStore;

class GetDomainEvents
{
    private $eventStore;
    private $response;

    public function __construct(EventStore $eventStore, GetDomainEventsResponse $response)
    {
        $this->eventStore = $eventStore;
        $this->response = $response;
    }

    public function __invoke(GetDomainEventsQuery $query) : array
    {
        $page = $query->page();
        $pageSize = $query->pageSize();
        $since = $query->since();

        $offset = ($page - 1) * $pageSize;

        $events = $this->eventStore->eventsSince($since, $offset, $pageSize);

        return $this->response->build($events, $page, $pageSize);
    }
}
