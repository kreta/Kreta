<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;
use Kreta\Component\VCS\Serializer\Registry\Interfaces\SerializerRegistryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Class GithubWebhookStrategySpec.
 *
 * @package spec\Kreta\Component\VCS\WebhookStrategy
 */
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

    function it_extends_abstract_webhook_strategy()
    {
        $this->shouldHaveType('Kreta\Component\VCS\WebhookStrategy\Abstracts\AbstractWebhookStrategy');
    }

    function it_gets_serializer_for_event(
        SerializerRegistryInterface $serializerRegistry,
        Request $request,
        SerializerInterface $serializer
    )
    {
        $request->headers = new HeaderBag(['X-Github-Event' => 'push']);

        $serializerRegistry->getSerializer('github', 'push')->shouldBeCalled()->willReturn($serializer);
        $this->getSerializer($request);
    }
}
