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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationPublished;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationStatus;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class SymfonyNotificationPublishedDenormalizer implements DenormalizerInterface
{
    private $nameConverter;

    public function __construct(NameConverterInterface $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }

    public function denormalize($data, $class, $format = null, array $context = []) : NotificationPublished
    {
        $notificationPublished = new NotificationPublished(
            NotificationId::generate($data['payload']['id']),
            UserId::generate($data['payload']['user_id']),
            new NotificationType($data['payload']['type']),
            new NotificationBody($data['payload']['body'])
        );

        $reflectionClass = new \ReflectionClass($notificationPublished);
        $reflectionProperty = $reflectionClass->getProperty('occurredOn');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(
            $notificationPublished,
            \DateTimeImmutable::createFromFormat('U', (string) $data['occurred_on'])
        );

        $reflectionProperty = $reflectionClass->getProperty('status');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(
            $notificationPublished,
            new NotificationStatus($data['payload']['status'])
        );

        return $notificationPublished;
    }

    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return isset($data['type'])
            && $this->nameConverter->denormalize($data['type']) === NotificationPublished::class;
    }
}
