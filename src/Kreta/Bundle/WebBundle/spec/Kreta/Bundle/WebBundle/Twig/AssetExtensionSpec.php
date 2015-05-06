<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\Twig;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AssetExtensionSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\Twig
 */
class AssetExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Twig\AssetExtension');
    }

    function it_extends_twig_extension()
    {
        $this->shouldHaveType('\Twig_Extension');
    }

    function it_gets_functions()
    {
        $this->getFunctions()->shouldBeArray();
    }
    
    function it_gets_name()
    {
        $this->getName()->shouldReturn('asset_extension');
    }
    
    function it_gets_javascript_files()
    {
        $this->getJavaScriptFiles('web/')->shouldBeArray();
    }
}
