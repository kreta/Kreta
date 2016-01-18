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

namespace spec\Kreta\Bundle\CoreBundle\DependencyInjection\Loader;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class YamlFileLoaderSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
