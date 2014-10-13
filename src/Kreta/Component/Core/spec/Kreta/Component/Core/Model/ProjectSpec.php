<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Model;

use Kreta\CoreBundle\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectSpec.
 *
 * @package spec\Kreta\CoreBundle\Model
 */
class ProjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Project');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Abstracts\AbstractModel');
    }

    function it_implements_project_interface()
    {
        $this->shouldImplement('Kreta\CoreBundle\Model\Interfaces\ProjectInterface');
    }

    function its_participants_is_collection()
    {
        $this->getParticipants()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name that it is a test for the PHPSpec');

        $this->getShortName()->shouldReturn('Dummy name that it is a te...');
    }

    function its_participants_be_mutable(UserInterface $participant)
    {
        $this->getParticipants()->shouldHaveCount(0);

        $this->addParticipant($participant);

        $this->getParticipants()->shouldHaveCount(1);

        $this->removeParticipant($participant);

        $this->getParticipants()->shouldHaveCount(0);
    }

    function its_short_name_is_mutable()
    {
        $this->setShortName('Dummy short name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name that it i...');

        $this->setShortName('Dummy short name')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name');
    }
}
