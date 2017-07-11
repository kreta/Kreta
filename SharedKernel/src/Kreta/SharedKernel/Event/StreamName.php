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

namespace Kreta\SharedKernel\Event;

use Kreta\SharedKernel\Domain\Model\Identity\Id;

class StreamName
{
    private $name;
    private $aggregateId;

    public function __construct(Id $aggregateId, string $name)
    {
        $this->setName($name);
        $this->aggregateId = $aggregateId;
    }

    private function setName(string $name) : void
    {
        $this->checkNameIsValid($name);
        $this->name = $name;
    }

    private function checkNameIsValid(string $name) : void
    {
        if ('' === $name) {
            throw new StreamNameIsEmpty();
        }
    }

    public function name() : string
    {
        return sprintf('%s-%s', $this->name, $this->aggregateId()->id());
    }

    public function aggregateId() : Id
    {
        return $this->aggregateId;
    }

    public function __toString() : string
    {
        return (string) $this->name();
    }
}
