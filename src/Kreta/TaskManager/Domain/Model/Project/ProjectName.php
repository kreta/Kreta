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

namespace Kreta\TaskManager\Domain\Model\Project;

class ProjectName
{
    private $name;

    public function __construct(string $name)
    {
        if ('' === $name) {
            throw new ProjectNameEmptyException();
        }
        $this->name = $name;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function __toString() : string
    {
        return (string) $this->name;
    }
}
