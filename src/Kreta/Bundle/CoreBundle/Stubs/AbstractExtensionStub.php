<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Stubs;

use Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Kreta\Bundle\CoreBundle\DependencyInjection\Configuration;

/**
 * Class AbstractExtensionStub.
 *
 * @package Kreta\Bundle\CoreBundle\Stubs
 */
class AbstractExtensionStub extends AbstractExtension
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
        return ['commands', 'handlers', 'listeners', 'subscribers'];
    }
}
