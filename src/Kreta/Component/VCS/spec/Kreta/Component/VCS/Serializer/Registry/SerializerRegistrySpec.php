<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Serializer\Registry;

use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class SerializerRegistrySpec.
 *
 * @package spec\Kreta\Component\VCS\Serializer\Registry
 */
class SerializerRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Serializer\Registry\SerializerRegistry');
    }

    function it_implement_serializer_registry_interface()
    {
        $this->shouldImplement('Kreta\Component\VCS\Serializer\Registry\Interfaces\SerializerRegistryInterface');
    }

    function it_gets_serializers_if_provider_exists(SerializerInterface $serializer)
    {
        $this->registerSerializer('github', 'push', $serializer);

        $this->getSerializers('github')->shouldReturn(['push' => $serializer]);
    }

    function it_throws_exception_if_provider_does_not_exist()
    {
        $this->shouldThrow('Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException')
            ->duringGetSerializers('unknown_provider');
    }

    function it_deletes_serializer_if_exists(SerializerInterface $serializer)
    {
        $this->registerSerializer('github', 'push', $serializer);

        $this->unregisterSerializer('github', 'push');
    }

    function it_throws_exception_if_serializer_to_delete_does_not_exist()
    {
        $this->shouldThrow('Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException')
            ->duringUnregisterSerializer('unknown_provider', 'unknown_event');
    }

    function it_checks_serializer_exists(SerializerInterface $serializer)
    {
        $this->registerSerializer('github', 'push', $serializer);

        $this->hasSerializer('github', 'push')->shouldReturn(true);

        $this->hasSerializer('unknown_provider', 'unknown_event')->shouldReturn(false);
    }

    function it_gets_serializer_if_exists(SerializerInterface $serializer)
    {
        $this->registerSerializer('github', 'push', $serializer);

        $this->getSerializer('github', 'push')->shouldReturn($serializer);
    }

    function it_throws_exception_if_serializer_does_not_exist()
    {
        $this->shouldThrow('Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException')
            ->duringGetSerializer('unknown_provider', 'unknown_event');
    }

    function it_throws_exception_when_adding_serializer_if_already_exists(SerializerInterface $serializer)
    {
        $this->registerSerializer('github', 'push', $serializer);

        $this->shouldThrow('Kreta\Component\VCS\Serializer\Registry\ExistingSerializerException')
            ->duringRegisterSerializer('github', 'push', $serializer);
    }
}
