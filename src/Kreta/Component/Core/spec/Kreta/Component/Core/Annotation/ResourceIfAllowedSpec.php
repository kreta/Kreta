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
