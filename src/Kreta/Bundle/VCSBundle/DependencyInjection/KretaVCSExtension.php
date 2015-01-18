<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class KretaVCSExtension.
 *
 * @package Kreta\Bundle\VCSBundle\DependencyInjection
 */
class KretaVCSExtension extends AbstractExtension
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
        return [
            'factories',
            'listeners',
            'matchers',
            'parameters',
            'repositories',
            'serializers',
            'strategies',
            'subscribers'
        ];
    }
}
