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

namespace spec\Kreta\Component\Organization\Model;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Organization\Model\Participant;
use Kreta\Component\Organization\Model\Organization;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Model\User;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of Organization class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Model\Organization');
    }

    function it_implements_organization_interface()
    {
        $this->shouldImplement('Kreta\Component\Organization\Model\Interfaces\OrganizationInterface');
    }

    function its_projects_and_participants_are_collection()
    {
        $this->getParticipants()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getProjects()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_image_is_mutable(MediaInterface $media)
    {
        $this->setImage($media)->shouldReturn($this);
        $this->getImage()->shouldReturn($media);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name');
        $this->getSlug()->shouldReturn('dummy-name');
    }

    function its_participants_are_be_mutable(ParticipantInterface $participant)
    {
        $this->getParticipants()->shouldHaveCount(0);

        $this->addParticipant($participant);

        $this->getParticipants()->shouldHaveCount(1);

        $this->removeParticipant($participant);

        $this->getParticipants()->shouldHaveCount(0);
    }

    function its_projects_are_mutable(ProjectInterface $project)
    {
        $this->getProjects()->shouldHaveCount(0);

        $this->addProject($project);

        $this->getProjects()->shouldHaveCount(1);

        $this->removeProject($project);

        $this->getProjects()->shouldHaveCount(0);
    }

    function its_slug_is_mutable()
    {
        $this->setSlug('dummy-slug')->shouldReturn($this);
        $this->getSlug()->shouldReturn('dummy-slug');
    }

    function it_does_not_get_user_role(UserInterface $anotherUser)
    {
        $organization = new Organization();
        $user = new User();
        $participant = new Participant($organization, $user);

        $this->addParticipant($participant)->shouldReturn($this);
        $anotherUser->getId()->shouldBeCalled()->willReturn('user-id');

        $this->getUserRole($anotherUser)->shouldReturn(null);
    }

    function it_gets_user_role(UserInterface $anotherUser)
    {
        $organization = new Organization();
        $user = new User();
        $participant = new Participant($organization, $user);
        $participant->setRole('ROLE_ADMIN');

        $this->addParticipant($participant)->shouldReturn($this);

        $this->getUserRole($anotherUser)->shouldReturn('ROLE_ADMIN');
    }
}
