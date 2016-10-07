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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Collection;
use Kreta\TaskManager\Domain\Model\Organization\ParticipantCollection;
use PhpSpec\ObjectBehavior;

class ParticipantCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParticipantCollection::class);
        $this->shouldHaveType(Collection::class);
    }
}
