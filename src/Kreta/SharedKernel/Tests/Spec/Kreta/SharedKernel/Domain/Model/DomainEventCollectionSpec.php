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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\SharedKernel\Domain\Model\Collection;
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyAddedException;
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyRemovedException;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\InvalidCollectionElementException;
use PhpSpec\ObjectBehavior;

class DomainEventCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DomainEventCollection::class);
    }

    function it_extends_collection()
    {
        $this->shouldHaveType(Collection::class);
    }

    function it_extends_doctrine_array_collection()
    {
        $this->shouldHaveType(ArrayCollection::class);
    }

    function it_creates_collection_with_an_invalid_element()
    {
        $this->beConstructedWith(['a-scalar-element']);
        $this->shouldThrow(InvalidCollectionElementException::class)->duringInstantiation();
    }

    function it_adds_to_collection_an_invalid_element()
    {
        $this->shouldThrow(InvalidCollectionElementException::class)->duringAdd('a-scalar-element');
    }

    function it_creates_collection_with_elements(DomainEvent $element, DomainEvent $element2)
    {
        $this->beConstructedWith([$element, $element2]);
        $this->toArray()->shouldReturn([$element, $element2]);
    }

    function it_adds_element_to_collection(DomainEvent $element)
    {
        $this->add($element);
        $this->toArray()->shouldReturn([$element]);
    }

    function it_removes_element_to_collection(DomainEvent $element)
    {
        $this->beConstructedWith([$element]);
        $this->remove($element);
        $this->toArray()->shouldReturn([]);
    }

    function it_does_not_add_already_added_element_from_collection(DomainEvent $element)
    {
        $this->beConstructedWith([$element]);
        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->duringAdd($element);
    }

    function it_does_not_remove_already_removed_element_from_collection(DomainEvent $element)
    {
        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->duringRemove($element);
    }
}
