<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class DataFixture.
 *
 * @package Kreta\FixturesBundle\DataFixtures
 */
abstract class DataFixtures extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * The path where there are located the projects' fixture images.
     *
     * @var string
     */
    protected $projectPath = '/../Resources/fixtures/media/image/projects';

    /**
     * The path where there are located the users' fixture photos.
     *
     * @var string
     */
    protected $userPath = '/../Resources/fixtures/media/image/users';

    /**
     * The container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Adds random users into collection of object given.
     *
     * @param Object   $object     The object
     * @param string   $method     The name of the method
     * @param Object[] $collection The object collection
     * @param int      $limit      The maximum limit of the index
     *
     * @return void
     */
    protected function loadRandomObjects($object, $method, array $collection, $limit = 5)
    {
        $randomAmount = rand(1, $limit);
        $index = rand(0, $limit);

        for ($j = 0; $j < $randomAmount; $j++) {
            if (count($collection) > $index) {
                $object->$method($collection[$index]);
                $index++;
            }
        }
    }

    /**
     * Agnostic method that loads medias of any uploader.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager         The manager
     * @param string                                     $uploaderService The uploader service
     * @param string                                     $path            The path
     *
     * @return \Kreta\Component\Core\Model\Interfaces\MediaInterface[]
     */
    protected function loadMedias(ObjectManager $manager, $uploaderService, $path)
    {
        $finder = new Finder();
        $medias = [];
        $uploader = $this->container->get($uploaderService);
        foreach ($finder->files()->in(__DIR__ . $path) as $file) {
            $media = $this->container->get('kreta_core.factory_media')
                ->create(new UploadedFile($file->getRealPath(), $file->getFilename()));
            $uploader->upload($media);
            $medias[] = $media;

            $manager->persist($media);
        }

        $manager->flush();

        return $medias;
    }
}
