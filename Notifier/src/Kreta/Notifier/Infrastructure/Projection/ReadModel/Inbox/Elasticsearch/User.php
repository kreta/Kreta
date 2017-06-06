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

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * @ES\Document(type="user")
 */
class User
{
    /**
     * @ES\Id()
     */
    public $id;

    /**
     * @ES\Embedded(class="Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Elasticsearch\Notification", multiple=true)
     */
    public $notifications;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->notifications = new Collection();
    }
}
