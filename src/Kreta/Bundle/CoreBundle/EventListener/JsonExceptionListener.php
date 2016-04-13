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

namespace Kreta\Bundle\CoreBundle\EventListener;

use Doctrine\ORM\NoResultException;
use Kreta\Component\Core\Exception\CollectionMinLengthException;
use Kreta\Component\Core\Exception\ResourceAlreadyPersistException;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonExceptionListener.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class JsonExceptionListener
{
    /**
     * Converts response into json which contains the exception message.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event The response event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getRequest()->getRequestFormat() === 'json') {
            $exception = $event->getException();
            $response = new JsonResponse();
            switch ($exception) {
                case $exception instanceof InvalidFormException:
                    $response->setStatusCode(400);
                    $response->setData($exception->getFormErrors());
                    break;
                case $exception instanceof \InvalidArgumentException:
                    $response->setStatusCode(400);
                    $response->setData(['error' => $exception->getMessage()]);
                    break;
                case $exception instanceof AccessDeniedException:
                    $response->setStatusCode(403);
                    $response->setData(['error' => 'Not allowed to access this resource']);
                    break;

                case $exception instanceof NoResultException:
                    $response->setStatusCode(404);
                    $response->setData(['error' => 'Does not exist any object with id passed']);
                    break;
                case $exception instanceof ResourceInUseException
                    || $exception instanceof ResourceAlreadyPersistException
                    || $exception instanceof CollectionMinLengthException
                :
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
