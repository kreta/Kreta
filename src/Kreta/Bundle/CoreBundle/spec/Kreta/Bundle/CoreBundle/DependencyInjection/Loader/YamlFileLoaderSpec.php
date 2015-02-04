<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\DependencyInjection\Loader;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class YamlFileLoaderSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DependencyInjection\Loader
 */
class YamlFileLoaderSpec extends ObjectBehavior
{
    function let(ContainerBuilder $container, FileLocatorInterface $locator)
    {
        $this->beConstructedWith($container,$locator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Loader\YamlFileLoader');
    }

    function it_loads_kreta_extension()
    {
        $this->loadFilesFromDirectory('');
    }
}
