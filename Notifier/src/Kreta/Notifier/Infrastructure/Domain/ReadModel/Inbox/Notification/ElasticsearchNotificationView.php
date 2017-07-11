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

namespace Kreta\Notifier\Infrastructure\Domain\ReadModel\Inbox\Notification;

use Elasticsearch\Client;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;

final class ElasticsearchNotificationView implements NotificationView
{
    private $elasticsearch;
    private $index;
    private $type;

    public function __construct(Client $elasticsearch, string $index, string $type)
    {
        $this->elasticsearch = $elasticsearch;
        $this->index = $index;
        $this->type = $type;
    }

    public function notificationOfId(NotificationId $notificationId) : ?Notification
    {
        $notificationData = $this->elasticsearch->get([
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $notificationId->id(),
        ]);

        return empty($notificationData)
            ? null
            : Notification::fromArray(
                $this->normalizeElasticsearchData($notificationData)
            );
    }

    public function search($searchSpecification) : array
    {
        $notificationsData = $this->elasticsearch->search(
            $searchSpecification->buildSearch($this->index, $this->type)
        );

        $result = array_map(function (array $notificationData) {
            return Notification::fromArray(
                $this->normalizeElasticsearchData($notificationData)
            );
        }, $notificationsData['hits']['hits']);

        return $result;
    }

    public function save(Notification $notification) : void
    {
        $this->elasticsearch->index([
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $notification->id,
            'body'  => [
                'user_id'      => $notification->userId,
                'body'         => $notification->body,
                'published_on' => $notification->publishedOn,
                'read_on'      => $notification->readOn,
                'status'       => $notification->status,
            ],
        ]);
    }

    private function normalizeElasticsearchData(array $elasticsearchData) : array
    {
        return array_merge(['id' => $elasticsearchData['_id']], $elasticsearchData['_source']);
    }
}
