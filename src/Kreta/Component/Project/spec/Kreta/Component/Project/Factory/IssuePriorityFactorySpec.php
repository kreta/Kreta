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

namespace spec\Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssuePriorityFactorySpec.
 *
 * @package spec\Kreta\Component\Project\Factory
 */
class IssuePriorityFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Project\Model\IssuePriority');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\IssuePriorityFactory');
    }

    function it_creates_a_issue_priority(ProjectInterface $project)
    {
        $this->create($project, 'Priority name', '#67b86a')->shouldReturnAnInstanceOf(
            'Kreta\Component\Project\Model\IssuePriority'
        );
    }
}
