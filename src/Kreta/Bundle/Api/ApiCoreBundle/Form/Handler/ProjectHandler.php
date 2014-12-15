<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Form\Handler;

use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\ProjectType;
use Kreta\Bundle\WebBundle\FormHandler\ProjectFormHandler as BaseProjectFormHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class ProjectHandler.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Handler
 */
class ProjectHandler extends BaseProjectFormHandler
{
    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        return $this->formFactory->create(new ProjectType(), $object, $formOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('image');
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setImage($media);
        }
    }
}
