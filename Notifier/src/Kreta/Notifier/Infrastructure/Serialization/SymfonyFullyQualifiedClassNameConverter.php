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

namespace Kreta\Notifier\Infrastructure\Serialization;

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class SymfonyFullyQualifiedClassNameConverter implements NameConverterInterface
{
    private $nameConverter;

    public function __construct(NameConverterInterface $nameConverter)
    {
        $this->nameConverter = $nameConverter;
    }

    public function normalize($propertyName) : string
    {
        if (false === class_exists($propertyName)) {
            throw new InvalidArgumentException('The given parameter is not a valid fully qualified class name');
        }

        $reflectionClass = new \ReflectionClass($propertyName);
        $className = $reflectionClass->getShortName();

        return $this->nameConverter->normalize($className);
    }

    public function denormalize($propertyName) : string
    {
        $className = $this->nameConverter->denormalize($propertyName);

        if (false !== mb_strpos($className, 'Notification')) {
            $className = 'Notification\\' . $className;
        }

        return 'Kreta\\Notifier\\Domain\\Model\\Inbox\\' . $className;
    }
}
