<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DependencyInjection\Loader;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as BaseYamlFileLoader;

/**
 * Class YamlFileLoader.
 *
 * @package Kreta\Bundle\CoreBundle\DependencyInjection\Loader
 */
class YamlFileLoader extends BaseYamlFileLoader
{
    /**
     * Load all YAML Files from directory.
     *
     * @param string $path Path for resources
     *
     * @return null
     */
    public function loadFilesFromDirectory($path)
    {
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if (strpos($file, '.yml')) {
                    if ($this->existInFile($path . '/' . $file, 'services')) {
                        $this->load($file);
                    }
                }
            }
        }
    }

    /**
     * Analyze content of YAML for search term.
     *
     * @param string $file Path for search content
     * @param string $searchTerm Searched term in file
     *
     * @return boolean
     */
    protected function existInFile($file, $searchTerm)
    {
        $parser = new Parser();
        $parsedResult = $parser->parse(file_get_contents($file));

        return is_null($parsedResult) ? false : array_key_exists($searchTerm, $parsedResult);
    }
}
