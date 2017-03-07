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

class NumericId
{
    private $id;

    public static function fromPrevious(int $id) : self
    {
        return new self(++$id);
    }

    public function __construct(int $id)
    {
        $this->setId($id);
    }

    private function setId(int $id) : void
    {
        $this->checkValidId($id);
        $this->id = $id;
    }

    private function checkValidId(int $id) : void
    {
        if (0 >= $id) {
            throw new NumericIdInvalidException($id);
        }
    }

    public function id() : int
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return (string) $this->id;
    }
}
