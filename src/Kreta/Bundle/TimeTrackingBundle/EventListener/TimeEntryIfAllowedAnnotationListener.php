<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\EventListener;

use Kreta\Bundle\CoreBundle\EventListener\ResourceIfAllowedAnnotationListener;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class TimeEntryIfAllowedAnnotationListener.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\EventListener
 */
class TimeEntryIfAllowedAnnotationListener extends ResourceIfAllowedAnnotationListener
{
    /**
     * {@inheritdoc}
     */
    public function onResourceIfAllowedAnnotationMethod(FilterControllerEvent $event)
    {
        list($object, $method) = $event->getController();
        $reflectionClass = new \ReflectionClass(get_class($object));
        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass)) {
            $resourceId = $event->getRequest()->attributes->get(sprintf('%sId', $this->resource));
            if (null !== $resourceId) {
                $grant = $this->resource === 'issue' ? 'view' : $annotation->getGrant();
                $event->getRequest()->attributes->set(
                    $this->resource, $this->getResourceIfAllowed($resourceId, $grant)
                );
            }
        }
    }
}
