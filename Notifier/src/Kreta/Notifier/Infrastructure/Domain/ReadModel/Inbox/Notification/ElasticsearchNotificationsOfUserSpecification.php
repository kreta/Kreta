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

use Kreta\SharedKernel\Infrastructure\Domain\ReadModel\ElasticsearchSearchSpecification;

class ElasticsearchNotificationsOfUserSpecification implements ElasticsearchSearchSpecification
{
    private $userId;
    private $from;
    private $size;
    private $status;

    public function __construct(string $userId, int $from, int $size, ?string $status)
    {
        $this->userId = $userId;
        $this->from = $from;
        $this->size = $size;
        $this->status = $status;
    }

    public function buildSearch(string $index, string $type) : array
    {
        $search = [
            'index' => $index,
            'type'  => $type,
            'body'  => [
                'from'  => $this->from,
                'size'  => $this->size,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'user_id' => $this->userId,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        if (!empty($this->status)) {
            $search['body']['query']['bool']['must'][]['match']['status'] = $this->status;
        }

        return $search;
    }
}
