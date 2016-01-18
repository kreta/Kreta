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

use Doctrine\ORM\NoResultException;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonExceptionListenerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class JsonExceptionListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\EventListener\JsonExceptionListener');
    }

    function it_converts_exception_into_json_response_by_default_option(
        GetResponseForExceptionEvent $event,
        Request $request,
        \Exception $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_kretas_ResourceInUse_ResourceAlreadyPersist_and_CollectionMinLength_exceptions_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        ResourceInUseException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_doctrines_no_result_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        NoResultException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_access_denied_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        AccessDeniedException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_invalid_argument_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        \InvalidArgumentException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_kretas_invalid_form_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        InvalidFormException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $exception->getFormErrors()->shouldBeCalled()->willReturn(
            ['name' =>
                 ['This value should not be blank', 'An object with identical name is already exists']
            ]
        );
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }
}
