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

namespace Kreta\SharedKernel\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Collection extends ArrayCollection
{
    abstract protected function type() : string;

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            $this->validate($element);
        }
        parent::__construct($elements);
    }

    public function add($element)
    {
        if ($this->contains($this->validate($element))) {
            throw new CollectionElementAlreadyAddedException();
        }
        parent::add($element);
    }

    public function remove($element)
    {
        if (!$this->contains($element)) {
            throw new CollectionElementAlreadyRemovedException();
        }
        $this->removeElement($element);
    }

    private function validate($element)
    {
        if (is_scalar($element) || !is_subclass_of($element, $this->type())) {
            throw new InvalidCollectionElementException();
        }

        return $element;
    }
}
