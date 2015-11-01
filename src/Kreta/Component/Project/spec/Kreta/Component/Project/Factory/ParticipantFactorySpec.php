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
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ParticipantFactorySpec.
 *
 * @package spec\Kreta\Component\Project\Factory
 */
class ParticipantFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Project\Model\Participant');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\ParticipantFactory');
    }

    function it_creates_a_participant(ProjectInterface $project, UserInterface $user)
    {
        $this->create($project, $user)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Participant');
    }
}
