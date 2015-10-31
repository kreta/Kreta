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

use Doctrine\Common\Annotations\Reader;
use Kreta\Component\Core\Repository\EntityRepository;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ResourceIfAllowedAnnotationListener.
 */
class ResourceIfAllowedAnnotationListener
{
    /**
     * The class name of the annotation, it has extracted
     * into a variable to make easier its extension.
     *
     * @var string
     */
    protected $annotationClass = 'Kreta\\Component\\Core\\Annotation\\ResourceIfAllowed';

    /**
     * The annotation reader.
     *
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $annotationReader;

    /**
     * The security context.
     *
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $context;

    /**
     * The entity repository.
     *
     * @var \Kreta\Component\Core\Repository\EntityRepository
     */
    protected $repository;

    /**
     * The resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Constructor.
     *
     * @param Reader                        $reader     The annotation reader
     * @param AuthorizationCheckerInterface $context    The authorization checker
     * @param EntityRepository              $repository The entity repository
     */
    public function __construct(Reader $reader, AuthorizationCheckerInterface $context, EntityRepository $repository)
    {
        $this->annotationReader = $reader;
        $this->context = $context;
        $this->repository = $repository;

        $reflection = new \ReflectionClass($this->repository->getClassName());
        $this->resource = lcfirst($reflection->getShortName());
    }

    /**
     * Listens when the annotation exists loading the resource of id given and if it is allowed.
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event The filter controller event
     */
    public function onResourceIfAllowedAnnotationMethod(FilterControllerEvent $event)
    {
        list($object, $method) = $event->getController();
        $reflectionClass = new \ReflectionClass(get_class($object));
        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass)) {
            $resourceId = $event->getRequest()->attributes->get(sprintf('%sId', $this->resource));
            if (null !== $resourceId) {
                $event->getRequest()->attributes->set(
                    $this->resource, $this->getResourceIfAllowed($resourceId, $annotation->getGrant())
                );
            }
        }
    }

    /**
     * Gets the resource if the current user is granted and if the resource exists.
     *
     * @param string $resourceId The resource id
     * @param string $grant      The grant, by default is view
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @return Object
     */
    protected function getResourceIfAllowed($resourceId, $grant = 'view')
    {
        $resource = $this->repository->find($resourceId, false);
        if (!$this->context->isGranted($grant, $resource)) {
            throw new AccessDeniedException();
        }

        return $resource;
    }
}
