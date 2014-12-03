<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class JsonExceptionListenerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\EventListener
 */
class JsonExceptionListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\EventListener\JsonExceptionListener');
    }

    function it_converts_exception_into_json_response(GetResponseForExceptionEvent $event, \Exception $exception)
    {
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }
}
