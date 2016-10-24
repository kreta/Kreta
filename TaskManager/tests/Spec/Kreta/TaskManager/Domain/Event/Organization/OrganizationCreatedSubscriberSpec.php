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

namespace Spec\Kreta\TaskManager\Domain\Event\Organization;

use Kreta\SharedKernel\Domain\Event\EventSubscriber;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Event\Organization\OrganizationCreatedSubscriber;
use PhpSpec\ObjectBehavior;

class OrganizationCreatedSubscriberSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationCreatedSubscriber::class);
        $this->shouldHaveType(EventSubscriber::class);
    }

    function it_can_be_handle(DomainEvent $event)
    {
        $this->handle($event);
    }
}
