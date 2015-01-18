<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CommentBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class KretaCommentExtension.
 *
 * @package Kreta\Bundle\CommentBundle\DependencyInjection
 */
class KretaCommentExtension extends AbstractExtension
{
    /**
     * Gets the Config file location.
     *
     * @return string
     */
    protected function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Gets array with all the config file names.
     *
     * @return string[]
     */
    protected function getConfigFiles()
    {
        return ['services', 'factories', 'parameters', 'repositories'];
    }
}
