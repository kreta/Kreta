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

namespace Kreta\Notifier\Infrastructure\Application\Query\Elasticsearch\Inbox;

use Kreta\Notifier\Application\Query\Inbox\GetNotificationsHandler;
use Kreta\Notifier\Application\Query\Inbox\GetNotificationsQuery;
use ONGR\ElasticsearchBundle\Service\Repository;

final class ElasticsearchGetNotificationsHandler implements GetNotificationsHandler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetNotificationsQuery $query) : array
    {
        // @TODO
    }
}
