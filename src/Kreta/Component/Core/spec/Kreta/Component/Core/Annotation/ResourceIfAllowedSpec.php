<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Annotation;

use PhpSpec\ObjectBehavior;

/**
 * Class ResourceIfAllowedSpecSpec.
 *
 * @package spec\Kreta\Component\Core\Annotation
 */
class ResourceIfAllowedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType('Kreta\Component\Core\Annotation\ResourceIfAllowed');
    }

    function it_gets_grant()
    {
        $this->beConstructedWith([]);
        $this->getGrant()->shouldReturn('view');
    }

    function it_gets_grant_when_the_grant_is_not_default_one()
    {
        $this->beConstructedWith(['value' => 'other-grant']);
        $this->getGrant()->shouldReturn('other-grant');
    }
}
