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

namespace spec\Kreta\Component\Organization\Factory;

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
use Kreta\Component\Organization\Factory\ParticipantFactory;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Spec file of OrganizationFactory class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationFactorySpec extends ObjectBehavior
{
    function let(ParticipantFactory $participantFactory, MediaFactory $mediaFactory, MediaUploaderInterface $uploader)
    {
        $this->beConstructedWith(
            'Kreta\Component\Organization\Model\Organization', $participantFactory, $mediaFactory, $uploader
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Factory\OrganizationFactory');
    }

    function it_creates_an_organization_without_image(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant
    ) {
        $participantFactory->create(
            Argument::type('Kreta\Component\Organization\Model\Organization'),
            $user,
            ParticipantInterface::ORG_ADMIN
        )->shouldBeCalled()->willReturn($participant);

        $this->create('Dummy name', $user)->shouldReturnAnInstanceOf('Kreta\Component\Organization\Model\Organization');
    }

    function it_creates_an_organization_passing_the_image(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        MediaUploaderInterface $uploader,
        MediaFactory $mediaFactory,
        MediaInterface $media
    ) {
        $image = new UploadedFile('', '', null, null, 99, true); // Avoids file not found exception
        $participantFactory->create(
            Argument::type('Kreta\Component\Organization\Model\Organization'),
            $user,
            ParticipantInterface::ORG_ADMIN
        )->shouldBeCalled()->willReturn($participant);

        $mediaFactory->create($image)->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();

        $this->create('Dummy name', $user, $image)
            ->shouldReturnAnInstanceOf('Kreta\Component\Organization\Model\Organization');
    }
}
