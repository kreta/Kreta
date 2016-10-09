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

namespace Spec\Kreta\TaskManager\Domain\Model\Project;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\ProjectEdited;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use PhpSpec\ObjectBehavior;

class ProjectEditedSpec extends ObjectBehavior
{
    function let(ProjectId $id)
    {
        $this->beConstructedWith($id);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectEdited::class);
        $this->shouldHaveType(DomainEvent::class);
    }

    function it_has_an_occurred_on_date()
    {
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_project_id(ProjectId $id)
    {
        $this->id()->shouldReturn($id);
    }
}
