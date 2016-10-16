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

class TaskProgress
{
    const TODO = 'todo';
    const DOING = 'doing';
    const DONE = 'done';

    private $progress;

    public function __construct(string $progress)
    {
        if ($progress !== self::TODO && $progress !== self::DOING && $progress !== self::DONE) {
            throw new TaskProgressNotAllowedException($progress);
        }
        $this->progress = $progress;
    }

    public static function todo()
    {
        return new self(self::TODO);
    }

    public static function doing()
    {
        return new self(self::DOING);
    }

    public static function done()
    {
        return new self(self::DONE);
    }

    public function progress() : string
    {
        return $this->progress;
    }

    public function __toString() : string
    {
        return $this->progress;
    }
}
