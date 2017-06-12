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

namespace Kreta\Notifier\Infrastructure\Serialization\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class SymfonyUserSignedUpDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = []) : UserSignedUp
    {
        $userSignedUp = new UserSignedUp(
            UserId::generate($data['payload']['user_id'])
        );

        $reflectionClass = new \ReflectionClass($userSignedUp);
        $reflectionProperty = $reflectionClass->getProperty('occurredOn');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($userSignedUp, $data['occurred_on']);

        return $userSignedUp;
    }

    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return isset($data['type']) && $data['type'] === UserSignedUp::class;
    }
}
