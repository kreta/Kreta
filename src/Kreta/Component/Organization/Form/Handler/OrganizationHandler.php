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

namespace Kreta\Component\Organization\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Organization form handler class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationHandler extends Handler
{
    /**
     * The media factory.
     *
     * @var MediaFactory
     */
    protected $mediaFactory;

    /**
     * The media uploader.
     *
     * @var MediaUploader
     */
    protected $uploader;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory  Creates a new Form instance
     * @param ObjectManager        $manager      Persists and flush the organization
     * @param string               $fqcn         The fully qualified namespace class of the form
     * @param MediaFactory         $mediaFactory Creates a new organization image
     * @param MediaUploader        $uploader     Uploads organization images
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        $fqcn,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    ) {
        parent::__construct($formFactory, $manager, $fqcn);
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $organization)
    {
        $image = $files->get('image');
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $organization->setImage($media);
        }
    }
}
