<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
