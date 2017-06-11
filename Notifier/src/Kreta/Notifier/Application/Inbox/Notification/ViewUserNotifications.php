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

namespace Kreta\Notifier\Application\Inbox\Notification;

use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationSpecificationFactory;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;

class ViewUserNotifications
{
    private $view;
    private $specificationFactory;

    public function __construct(NotificationView $view, NotificationSpecificationFactory $specificationFactory)
    {
        $this->view = $view;
        $this->specificationFactory = $specificationFactory;
    }

    public function __invoke(ViewUserNotificationsQuery $query) : array
    {
        $userId = $query->userId();
        $from = $query->offset();
        $size = $query->limit();
        $status = $query->status();

        return $this->view->search(
            $this->specificationFactory->createNotificationsOfUser(
                $userId,
                $from,
                $size,
                $status
            )
        );
    }
}
