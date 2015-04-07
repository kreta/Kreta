<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\MediaBundle\EventSubscriber;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Project;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class MediaUrlSubscriberSpec.
 *
 * @package spec\Kreta\Bundle\MediaBundle\EventSubscriber
 */
class MediaUrlSubscriberSpec extends ObjectBehavior
{
    function let(Router $router)
    {
        $this->beConstructedWith($router, 'Kreta\Component\Project\Model\Project', 'image');
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
                    'method' => 'onChangeObjectMedia'
                ]
            ]
        );
    }

    function it_does_not_change_object_media_because_the_object_does_not_be_a_class_instance(ObjectEvent $event)
    {
        $event->getObject()->shouldBeCalled()->willReturn(Argument::not('Kreta\Component\Project\Model\Project'));

        $this->onChangeObjectMedia($event);
    }

    function it_does_not_change_object_media_because_the_image_does_not_be_an_media(
        ObjectEvent $event,
        Project $project
    )
    {
        $event->getObject()->shouldBeCalled()->willReturn($project);
        $project->getImage()->shouldBeCalled()->willReturn(Argument::not('Kreta\Component\Core\Model\Media'));

        $this->onChangeObjectMedia($event);
    }

    function it_does_not_change_object_media_because_the_media_already_has_a_href_as_name(
        ObjectEvent $event,
        Project $project,
        MediaInterface $media
    )
    {
        $event->getObject()->shouldBeCalled()->willReturn($project);
        $project->getImage()->shouldBeCalled()->willReturn($media);
        $media->getName()->shouldBeCalled()->willReturn('http://kreta.io/media/media/media-name.jpg');

        $this->onChangeObjectMedia($event);
    }

    function it_changes_media_name(
        ObjectEvent $event,
        Project $project,
        MediaInterface $media,
        Router $router
    )
    {
        $event->getObject()->shouldBeCalled()->willReturn($project);
        $project->getImage()->shouldBeCalled()->willReturn($media);

        $media->getName()->shouldBeCalled()->willReturn('media-name.jpg');

        $router->generate('kreta_media_image', ['name' => 'media-name.jpg'], true)
            ->shouldBeCalled()->willReturn('http://kreta.io/media/media/media-name.jpg');

        $media->setName('http://kreta.io/media/media/media-name.jpg')->shouldBeCalled()->willReturn($media);
        $project->setImage($media)->shouldBeCalled()->willReturn($project);

        $this->onChangeObjectMedia($event);
    }
}
