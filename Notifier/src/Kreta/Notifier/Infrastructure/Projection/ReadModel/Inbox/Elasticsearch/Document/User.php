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

use ONGR\ElasticsearchBundle\Annotation as Elasticsearch;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * @Elasticsearch\Document(type="user")
 */
class User
{
    /**
     * @Elasticsearch\Id()
     */
    public $id;

    /**
     * @Elasticsearch\Embedded(
     *     class="Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Elasticsearch\Document\Notification",
     *     multiple=true
     * )
     */
    public $notifications;

    public function __construct(string $id = null)
    {
        $this->id = $id;
        $this->notifications = new Collection();
    }
}
