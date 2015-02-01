<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\EventListener;

use Doctrine\ORM\NoResultException;
use Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException;
use Kreta\Component\Core\Exception\CollectionMinLengthException;
use Kreta\Component\Core\Exception\ResourceAlreadyPersistException;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonExceptionListener.
 *
 * @package Kreta\Bundle\CoreBundle\EventListener
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
                case ($exception instanceof InvalidFormException):
                    $response->setStatusCode(400);
                    $response->setData($exception->getFormErrors());
                    break;
                case ($exception instanceof \InvalidArgumentException):
                    $response->setStatusCode(400);
                    $response->setData(['error' => $exception->getMessage()]);
                    break;
                case ($exception instanceof AccessDeniedException):
                    $response->setStatusCode(403);
                    $response->setData(['error' => 'Not allowed to access this resource']);
                    break;

                case ($exception instanceof NoResultException):
                    $response->setStatusCode(404);
                    $response->setData(['error' => 'Does not exist any object with id passed']);
                    break;
                case ($exception instanceof ResourceInUseException
                    || $exception instanceof ResourceAlreadyPersistException
                    || $exception instanceof CollectionMinLengthException
                ):
                    $response->setStatusCode(409);
                    $response->setData(['error' => $exception->getMessage()]);
                    break;
                default:
                    $response->setData(['error' => $exception->getMessage()]);
            }
            $event->setResponse($response);
        }
    }
}
