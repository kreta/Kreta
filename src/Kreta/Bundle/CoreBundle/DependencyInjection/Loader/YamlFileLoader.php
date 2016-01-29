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

namespace Kreta\Bundle\CoreBundle\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as BaseYamlFileLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlFileLoader.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class YamlFileLoader extends BaseYamlFileLoader
{
    /**
     * Loads all YAML files from directory.
     *
     * @param string $path Path for resources
     */
    public function loadFilesFromDirectory($path)
    {
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if (strpos($file, '.yml')) {
                    if ($this->existInFile($path . '/' . $file, ['services', 'parameters'])) {
                        $this->load($file);
                    }
                }
            }
        }
    }

    /**
     * Analyzes content of YAML for search term.
     *
     * @param string $file        Path for search content
     * @param array  $searchTerms Array which contains terms for search
     *
     * @return bool
     */
    protected function existInFile($file, array $searchTerms)
    {
        $parser = new Parser();
        $filesystem = new Filesystem();
        if (true === $filesystem->exists($file)) {
            $parsedResult = $parser->parse(file_get_contents($file));
        }

        if (isset($parsedResult)) {
            foreach ($searchTerms as $searchTerm) {
                if (array_key_exists($searchTerm, $parsedResult)) {
                    return true;
                }
            }
        }

        return false;
    }
}
