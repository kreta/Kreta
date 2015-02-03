<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\EventSubscriber;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class MediaUrlSubscriber.
 *
 * @package Kreta\Bundle\CoreBundle\EventSubscriber
 */
class MediaUrlSubscriber implements EventSubscriberInterface
{
    /**
     * The router.
     *
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;

    /**
     * Constructor.
     *
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $router The router instance
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'  => 'serializer.pre_serialize',
                'method' => 'onChangeProjectImage'
            ]
        ];
    }

    /**
     * Event that updates the image attribute of project object,
     * turning the name of the image into the absolute url.
     *
     * @param \JMS\Serializer\EventDispatcher\ObjectEvent $event The event
     *
     * @return void
     */
    public function onChangeProjectImage(ObjectEvent $event)
    {
        if ($event->getObject() instanceof ProjectInterface) {
            $project = $event->getObject();
            $image = $project->getImage();

            if ($image instanceof MediaInterface) {
                $project->setImage(
                    $image->setName($this->router->generate('kreta_media_image', ['name' => $image->getName()], true))
                );
            }
        }
    }
}
