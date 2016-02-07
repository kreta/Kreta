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

namespace Kreta\Component\Organization\Factory;

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Organization factory class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The participant factory.
     *
     * @var ParticipantFactory
     */
    protected $participantFactory;

    /**
     * The media factory.
     *
     * @var MediaFactory
     */
    protected $mediaFactory;

    /**
     * The uploader.
     *
     * @var MediaUploaderInterface
     */
    protected $uploader;

    /**
     * Constructor.
     *
     * @param string                 $className          The class name
     * @param ParticipantFactory     $participantFactory Factory needed to add creator as participant
     * @param MediaFactory           $mediaFactory       The media factory
     * @param MediaUploaderInterface $uploader           The uploader
     */
    public function __construct(
        $className,
        ParticipantFactory $participantFactory,
        MediaFactory $mediaFactory,
        MediaUploaderInterface $uploader
    ) {
        $this->className = $className;
        $this->participantFactory = $participantFactory;
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * Creates an instance of a organization.
     *
     * @param string        $name  The organization name
     * @param UserInterface $user  The project creator
     * @param UploadedFile  $image The image, can be null
     *
     * @return \Kreta\Component\Organization\Model\Interfaces\OrganizationInterface
     */
    public function create($name, UserInterface $user, UploadedFile $image = null)
    {
        $organization = new $this->className();

        $participant = $this->participantFactory->create($organization, $user, ParticipantInterface::ORG_ADMIN);

        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $organization->setImage($media);
        }

        return $organization
            ->setName($name)
            ->addParticipant($participant);
    }
}
