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

namespace spec\Kreta\Bundle\MediaBundle\EventSubscriber;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use Kreta\Bundle\MediaBundle\Stubs\ObjectStub;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class MediaUrlSubscriberSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class MediaUrlSubscriberSpec extends ObjectBehavior
{
    function let(Router $router)
    {
        $this->beConstructedWith($router, 'Kreta\Bundle\MediaBundle\Stubs\ObjectStub', 'image');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\MediaBundle\EventSubscriber\MediaUrlSubscriber');
    }

    function it_implements_event_subscriber_interface()
    {
        $this->shouldImplement('JMS\Serializer\EventDispatcher\EventSubscriberInterface');
    }

    function it_gets_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldReturn(
            [
                [
                    'event'  => 'serializer.pre_serialize',
                    'method' => 'onChangeObjectMedia',
                ],
            ]
        );
    }

    function it_does_not_change_object_media_because_the_object_does_not_be_a_class_instance(ObjectEvent $event)
    {
        $event->getObject()->shouldBeCalled()->willReturn(Argument::not('Kreta\Bundle\MediaBundle\Stubs\ObjectStub'));

        $this->onChangeObjectMedia($event);
    }

    function it_does_not_change_object_media_because_the_image_does_not_be_an_media(
        ObjectEvent $event,
        ObjectStub $object
    ) {
        $event->getObject()->shouldBeCalled()->willReturn($object);
        $object->getImage()->shouldBeCalled()->willReturn(Argument::not('Kreta\Component\Core\Model\Media'));

        $this->onChangeObjectMedia($event);
    }

    function it_does_not_change_object_media_because_the_media_already_has_a_href_as_name(
        ObjectEvent $event,
        ObjectStub $object,
        MediaInterface $media
    ) {
        $event->getObject()->shouldBeCalled()->willReturn($object);
        $object->getImage()->shouldBeCalled()->willReturn($media);
        $media->getName()->shouldBeCalled()->willReturn('http://kreta.io/media/media/media-name.jpg');

        $this->onChangeObjectMedia($event);
    }

    function it_changes_media_name(
        ObjectEvent $event,
        ObjectStub $object,
        MediaInterface $media,
        Router $router
    ) {
        $event->getObject()->shouldBeCalled()->willReturn($object);
        $object->getImage()->shouldBeCalled()->willReturn($media);

        $media->getName()->shouldBeCalled()->willReturn('media-name.jpg');

        $router->generate('kreta_media_image', ['name' => 'media-name.jpg'], UrlGeneratorInterface::ABSOLUTE_URL)
            ->shouldBeCalled()->willReturn('http://kreta.io/media/media/media-name.jpg');

        $media->setName('http://kreta.io/media/media/media-name.jpg')->shouldBeCalled()->willReturn($media);
        $object->setImage($media)->shouldBeCalled()->willReturn($object);

        $this->onChangeObjectMedia($event);
    }
}
