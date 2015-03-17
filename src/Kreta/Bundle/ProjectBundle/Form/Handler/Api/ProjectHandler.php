<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Handler\Api;

use Kreta\Bundle\ProjectBundle\Form\Handler\ProjectHandler as BaseProjectFormHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class ProjectHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class ProjectHandler extends BaseProjectFormHandler
{
    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->createNamedBuilder(
            '', 'kreta_project_project_type', $object, $formOptions
        )->getForm();

    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $project)
    {
        $image = $files->get('image');
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $project->setImage($media);
        }
    }
}
