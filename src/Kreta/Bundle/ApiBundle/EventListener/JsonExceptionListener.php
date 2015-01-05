<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\EventListener;

use Doctrine\ORM\NoResultException;
use Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class JsonExceptionListener.
 *
 * @package Kreta\Bundle\ApiBundle\EventListener
 */
class JsonExceptionListener
{
    /**
     * Converts response into json which contains the exception message.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event The response event
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getRequest()->getRequestFormat() === 'json') {
            $exception = $event->getException();
            $response = new JsonResponse();
            switch ($exception) {
                case ($exception instanceof NoResultException):
                    $response->setStatusCode(404);
                    $response->setData(['error' => 'Does not exist any object with id passed']);
                    break;
                case ($exception instanceof InvalidFormException):
                    $response->setStatusCode(400);
                    $response->setData($exception->getFormErrors());
                    break;
                default:
                    $response->setData(['error' => $exception->getMessage()]);
            }
            $event->setResponse($response);
        }
    }
}
