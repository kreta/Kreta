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

namespace Kreta\Notifier\Infrastructure\Projection\EventHandler\Elasticsearch\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Elasticsearch\Document\User;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\EventHandler;
use ONGR\ElasticsearchBundle\Service\Repository;

class ElasticsearchUserSignedUpEventHandler implements EventHandler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function eventType() : string
    {
        return UserSignedUp::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $user = new User($event->userId()->id());

        $this->repository->getManager()->persist($user);
        $this->repository->getManager()->commit();
    }
}
