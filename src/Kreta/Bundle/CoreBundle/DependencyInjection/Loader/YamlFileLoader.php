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
     * Loads all YAML files from directory.
     *
     * @param string $path Path for resources
     *
     * @return void
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
     * @return boolean
     */
    protected function existInFile($file, array $searchTerms)
    {
        $parser = new Parser();
        $parsedResult = $parser->parse(file_get_contents($file));

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
