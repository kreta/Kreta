<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\EventSubscriber;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use Kreta\Component\Core\Model\Interfaces\MediaInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class MediaUrlSubscriberSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\EventSubscriber
 */
class MediaUrlSubscriberSpec extends ObjectBehavior
{
    function let(Router $router)
    {
        $this->beConstructedWith($router);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\EventSubscriber\MediaUrlSubscriber');
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
                    'method' => 'onChangeProjectImage'
                ]
            ]
        );
    }

    function it_does_not_change_project_image_because_the_object_does_not_be_an_project(ObjectEvent $event)
    {
        $event->getObject()->shouldBeCalled()->willReturn(Argument::not('Kreta\Component\Core\Model\Project'));

        $this->onChangeProjectImage($event);
    }

    function it_does_not_change_project_image_because_the_image_does_not_be_an_media(
        ObjectEvent $event,
        ProjectInterface $project
    )
    {
        $event->getObject()->shouldBeCalled()->willReturn($project);
        $project->getImage()->shouldBeCalled()->willReturn(Argument::not('Kreta\Component\Core\Model\Media'));

        $this->onChangeProjectImage($event);
    }

    function it_changes_project_image_name(
        ObjectEvent $event,
        ProjectInterface $project,
        MediaInterface $image,
        Router $router
    )
    {
        $event->getObject()->shouldBeCalled()->willReturn($project);
        $project->getImage()->shouldBeCalled()->willReturn($image);

        $image->getName()->shouldBeCalled()->willReturn('image-name.jpg');

        $router->generate('kreta_media_image', ['name' => 'image-name.jpg'], true)
            ->shouldBeCalled()->willReturn('http://kreta.io/media/image/image-name.jpg');

        $image->setName('http://kreta.io/media/image/image-name.jpg')->shouldBeCalled()->willReturn($image);
        $project->setImage($image)->shouldBeCalled()->willReturn($project);

        $this->onChangeProjectImage($event);
    }
}
