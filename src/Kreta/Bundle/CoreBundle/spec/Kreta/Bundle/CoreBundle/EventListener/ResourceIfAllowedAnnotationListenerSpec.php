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
use Kreta\Component\Core\Repository\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ResourceIfAllowedAnnotationListenerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ResourceIfAllowedAnnotationListenerSpec extends ObjectBehavior
{
    function let(Reader $reader, AuthorizationCheckerInterface $context, EntityRepository $repository)
    {
        $repository->getClassName()->shouldBeCalled()->willReturn(Argument::type('string'));
        $this->beConstructedWith($reader, $context, $repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\EventListener\ResourceIfAllowedAnnotationListener');
    }
}
