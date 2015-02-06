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
        $files = [];
        foreach (array_map('basename', glob($directory . '*.js')) as $jsFilename) {
            $files[] = $jsFilename;
        }

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'asset_extension';
    }
}
