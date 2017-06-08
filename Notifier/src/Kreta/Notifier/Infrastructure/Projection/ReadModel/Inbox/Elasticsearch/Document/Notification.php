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

namespace Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Elasticsearch\Document;

use Kreta\Notifier\Domain\Model\Inbox\NotificationStatus;
use ONGR\ElasticsearchBundle\Annotation as Elasticsearch;

/**
 * @Elasticsearch\Object()
 */
class Notification
{
    /**
     * @Elasticsearch\Property(type="string")
     */
    public $id;

    /**
     * @Elasticsearch\Property(type="text")
     */
    public $body;

    /**
     * @Elasticsearch\Property(type="integer")
     */
    public $publishedOn;

    /**
     * @Elasticsearch\Property(type="integer")
     */
    public $readOn;

    /**
     * @Elasticsearch\Property(type="string")
     */
    public $status;

    public function __construct(string $id = null, string $body = null, int $publishedOn = null)
    {
        $this->id = $id;
        $this->body = $body;
        $this->publishedOn = $publishedOn;
        $this->status = (NotificationStatus::unread())->status();
    }
}
