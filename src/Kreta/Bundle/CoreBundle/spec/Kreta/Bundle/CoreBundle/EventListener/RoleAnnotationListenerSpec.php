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

namespace spec\Kreta\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class RoleAnnotationListenerSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\EventListener
 */
class RoleAnnotationListenerSpec extends ObjectBehavior
{
    function let(Reader $reader, TokenStorageInterface $context)
    {
        $this->beConstructedWith($reader, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\EventListener\RoleAnnotationListener');
    }
}
