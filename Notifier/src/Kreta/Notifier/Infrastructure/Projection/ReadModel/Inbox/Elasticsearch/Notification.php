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

namespace Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Elasticsearch;

use Kreta\Notifier\Domain\Model\Inbox\NotificationStatus;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * @ES\Object()
 */
class Notification
{
    /**
     * @ES\Property(type="string")
     */
    public $id;

    /**
     * @ES\Property(type="string")
     */
    public $body;

    /**
     * @ES\Property(type="datetime")
     */
    public $publishedOn;

    /**
     * @ES\Property(type="datetime")
     */
    public $readOn;

    /**
     * @ES\Property(type="string")
     */
    public $status;

    public function __construct(string $id, string $body, \DateTimeInterface $publishedOn)
    {
        $this->id = $id;
        $this->body = $body;
        $this->publishedOn = $publishedOn;
        $this->status = (NotificationStatus::unread())->status();
    }
}
