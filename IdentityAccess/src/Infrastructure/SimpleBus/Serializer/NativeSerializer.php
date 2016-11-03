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

namespace Kreta\IdentityAccess\Infrastructure\SimpleBus\Serializer;

use SimpleBus\Serialization\ObjectSerializer;

class PlainSerializer implements ObjectSerializer
{
    public function serialize($object)
    {
        return $this->serialize($object);
    }

    public function deserialize($serializedObject, $type)
    {
        return unserialize($serializedObject);
    }
}
