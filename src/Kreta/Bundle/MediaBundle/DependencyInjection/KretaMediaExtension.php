<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\MediaBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class KretaCommentExtension.
 *
 * @package Kreta\Bundle\MediaBundle\DependencyInjection
 */
class KretaMediaExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigurationInstance()
    {
        return new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigFiles()
    {
        return ['services', 'factories', 'parameters'];
    }
}
