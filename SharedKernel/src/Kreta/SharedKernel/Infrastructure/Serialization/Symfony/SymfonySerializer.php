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

namespace Kreta\SharedKernel\Infrastructure\Serialization\Symfony;

use Kreta\SharedKernel\Serialization\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class SymfonySerializer implements Serializer
{
    private const FORMAT = 'json';

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize($object) : string
    {
        return $this->serializer->serialize($object, self::FORMAT);
    }

    public function deserialize(string $serializedObject)
    {
        return $this->serializer->deserialize($serializedObject, '', self::FORMAT);
    }
}
