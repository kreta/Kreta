<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class KretaVCSBundleSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle
 */
class KretaVCSBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\KretaVCSBundle');
    }

    function it_extends_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }

    function it_builds_extension(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            Argument::type('\Kreta\Bundle\VCSBundle\DependencyInjection\Compiler\RegisterSerializersPass')
        )->shouldBeCalled();

        $this->build($container);
    }
}
