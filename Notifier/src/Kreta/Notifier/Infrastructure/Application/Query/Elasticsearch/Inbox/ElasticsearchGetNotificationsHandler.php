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
use ONGR\ElasticsearchDSL\Query\TermLevel\IdsQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

final class ElasticsearchGetNotificationsHandler implements GetNotificationsHandler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetNotificationsQuery $query) : array
    {
        $userId = $query->userId();
        $offset = $query->offset();
        $limit = $query->limit();
        $status = $query->status();

        $search = $this->repository->createSearch();
        $search->setSize($limit);
        $search->setFrom($offset);

        $search->addQuery(new IdsQuery([$userId]));
        if (null !== $status) {
            $search->addQuery(new TermQuery('notifications.status', $status));
        }

        $user = $this->repository->findDocuments($search)->current();

        $result = [];
        foreach ($user->notifications as $notification) {
            $result['notifications'][] = $notification;
        }

        return $result;
    }
}
