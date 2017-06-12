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

namespace Kreta\Notifier\Infrastructure\Serialization\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsUnread;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SymfonyNotificationMarkedAsUnreadNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = []) : array
    {
        return [
            'type'        => get_class($object),
            'occurred_on' => $object->occurredOn()->getTimestamp(),
            'payload'     => [
                'id'      => $object->notificationId()->id(),
                'user_id' => $object->userId()->id(),
                'status'  => $object->status()->status(),
            ],
        ];
    }

    public function supportsNormalization($data, $format = null) : bool
    {
        return $data instanceof NotificationMarkedAsUnread;
    }
}
