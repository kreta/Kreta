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
use Kreta\Component\Core\Repository\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ResourceIfAllowedAnnotationListenerSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\EventListener
 */
class ResourceIfAllowedAnnotationListenerSpec extends ObjectBehavior
{
    function let(Reader $reader, TokenStorageInterface $context, EntityRepository $repository)
    {
        $repository->getClassName()->shouldBeCalled()->willReturn(Argument::type('string'));
        $this->beConstructedWith($reader, $context, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\EventListener\ResourceIfAllowedAnnotationListener');
    }
}
