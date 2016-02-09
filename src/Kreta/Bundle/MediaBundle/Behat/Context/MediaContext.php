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

namespace Kreta\Bundle\MediaBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Class MediaContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class MediaContext extends DefaultContext
{
    /**
     * Populates the database with medias.
     *
     * @param \Behat\Gherkin\Node\TableNode $medias The medias
     *
     *
     * @Given /^the following medias exist:$/
     */
    public function theFollowingMediasExist(TableNode $medias)
    {
        foreach ($medias as $mediaData) {
            $finder = new Finder();
            $filename = $mediaData['name'];
            $uploader = $this->get($this->getUploader($filename));

            $reflectionClass = new \ReflectionClass($this);
            $directory = dirname($reflectionClass->getFileName()) . '/..' . $this->getPath($filename);

            foreach ($finder->files()->in($directory)->name($filename) as $file) {
                $media = $this->get('kreta_media.factory.media')
                    ->create(new UploadedFile($file->getRealPath(), $file->getFilename()));

                if (isset($mediaData['createdAt'])) {
                    $this->setField($media, 'createdAt', new \DateTime($mediaData['createdAt']));
                }
                if (isset($mediaData['id'])) {
                    $this->setId($media, $mediaData['id']);
                }
                $uploader->upload($media, $filename, true);
                $this->getManager()->persist($media);
                $this->addMedia($media, $mediaData['resource']);
            }
        }
        $this->getManager()->flush();
    }

    /**
     * Gets the path directory of name given.
     *
     * @param string $name The name that will use to choose the path directory
     *
     * @return string
     */
    protected function getPath($name)
    {
        switch (true) {
            case strpos($name, 'organization') !== false:
                return '/Resources/image/organizations';
            case strpos($name, 'project') !== false:
                return '/Resources/image/projects';
            case strpos($name, 'user') !== false:
                return '/Resources/image/users';
        }
        throw new RouteNotFoundException(sprintf('composed by "%s"', $name));
    }

    /**
     * Gets the uploader service of name given.
     *
     * @param string $name The name that will use to choose the uploader
     *
     * @return string
     */
    protected function getUploader($name)
    {
        switch (true) {
            case strpos($name, 'organization') !== false:
                return 'kreta_organization.uploader.image_organization';
            case strpos($name, 'project') !== false:
                return 'kreta_project.uploader.image_project';
            case strpos($name, 'user') !== false:
                return 'kreta_user.uploader.image_user';
        }
        throw new ServiceNotFoundException(sprintf('composed by "%s"', $name));
    }

    /**
     * Adds media to resource.
     *
     * @param MediaInterface $media    The media
     * @param string         $resource Resource where the media will be added
     *
     * @return self $this Object
     */
    protected function addMedia(MediaInterface $media, $resource)
    {
        $result = $this->get('kreta_organization.repository.organization')->findOneBy(['name' => $resource]);
        if ($result instanceof OrganizationInterface) {
            $result->setImage($media);
            $this->getManager()->persist($result);

            return $this;
        }
        $result = $this->get('kreta_project.repository.project')->findOneBy(['name' => $resource]);
        if ($result instanceof ProjectInterface) {
            $result->setImage($media);
            $this->getManager()->persist($result);

            return $this;
        }
        $result = $this->get('kreta_user.repository.user')->findOneBy(['email' => $resource]);
        if ($result instanceof UserInterface) {
            $result->setPhoto($media);
            $this->getManager()->persist($result);

            return $this;
        }
    }
}
