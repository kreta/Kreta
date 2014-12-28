<?php

namespace spec\Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;
use Kreta\Component\VCS\Serializer\Registry\SerializerRegistryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderBag;

class GithubWebhookStrategySpec extends ObjectBehavior
{
    function let(SerializerRegistryInterface $serializerRegistry)
    {
        $this->beConstructedWith($serializerRegistry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\WebhookStrategy\GithubWebhookStrategy');
    }

    function it_gets_serializer_for_event(SerializerRegistryInterface $serializerRegistry, Request $request,
                                          SerializerInterface $serializer)
    {
        $request->headers = new HeaderBag(['X-Github-Event' => 'push']);

        $serializerRegistry->getSerializer('github', 'push')->shouldBeCalled()->willReturn($serializer);
        $this->getSerializer($request);
    }

}
