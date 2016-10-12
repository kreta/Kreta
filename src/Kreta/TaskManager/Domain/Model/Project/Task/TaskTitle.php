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

namespace Kreta\TaskManager\Domain\Model\Project\Task;

class TaskTitle
{
    private $title;

    public function __construct(string $title)
    {
        if ($title === '') {
            throw new TaskTitleCannotBeEmptyException();
        }

        $this->title = $title;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function __toString() : string
    {
        return $this->title;
    }
}
