<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Twig;

use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

/**
 * Class AssetExtension.
 *
 * @package Kreta\Bundle\WebBundle\Twig
 */
class AssetExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('javascripts', [$this, 'getJavaScriptFiles']),
        ];
    }

    /**
     * Gets all the JavaScript files from directory given.
     *
     * @param string $directory The directory path
     *
     * @return array
     */
    public function getJavaScriptFiles($directory)
    {
        return $this->getAssets($directory, 'js');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'asset_extension';
    }

    /**
     * Gets all the assets files of extension given and from directory given.
     *
     * @param string $directory     The directory path
     * @param string $fileExtension The extension of assets that will be find
     *
     * @return array
     */
    protected function getAssets($directory, $fileExtension)
    {
        $paths = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveIteratorIterator::SELF_FIRST, true),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $files = [];
        foreach ($paths as $name => $result) {
            if ($result->isFile() && $result->getExtension() === $fileExtension) {
                $files[] = $name;
            }
        }

        return $files;
    }
}
