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

interface EventStore
{
    public function append(Stream $stream) : void;

    public function streamOfName(StreamName $name) : Stream;

    public function eventsSince(?\DateTimeInterface $since, int $offset = 0, int $limit = -1) : array;
}
