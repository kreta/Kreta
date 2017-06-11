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

namespace Kreta\Notifier\Infrastructure\Domain\ReadModel\Inbox;

use Elasticsearch\Client;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\ReadModel\Inbox\User;
use Kreta\Notifier\Domain\ReadModel\Inbox\UserView;

final class ElasticsearchUserView implements UserView
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

    public function userOfId(UserId $userId) : ?User
    {
        $userData = $this->elasticsearch->get([
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $userId->id(),
        ]);

        return empty($userData) ? null : User::fromArray($this->normalizeElasticsearchData($userData));
    }

    public function save(User $user) : void
    {
        $this->elasticsearch->index([
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $user->id,
            'body'  => [],
        ]);
    }

    private function normalizeElasticsearchData(array $elasticsearchData) : array
    {
        return array_merge(['id' => $elasticsearchData['_id']], $elasticsearchData['_source']);
    }
}
