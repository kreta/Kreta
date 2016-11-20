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

namespace Kreta\SharedKernel\Serialization;

abstract class NameResolver implements Resolver
{
    abstract protected function map() : array;

    public function resolve(string $className) : string
    {
        if (!array_key_exists($className, $this->map())) {
            throw new ClassNameDoesNotExistException($className);
        }

        return $this->map()[$className];
    }
}
