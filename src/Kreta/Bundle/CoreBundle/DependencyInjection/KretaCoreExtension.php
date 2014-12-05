<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class KretaCoreExtension.
 *
 * @package Kreta\Bundle\CoreBundle\DependencyInjection
 */
class KretaCoreExtension extends AbstractExtension
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
    protected function getConfigFiles()
    {
        return ['services', 'factories', 'parameters', 'repositories'];
    }
}
