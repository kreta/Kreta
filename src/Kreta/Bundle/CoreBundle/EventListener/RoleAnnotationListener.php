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
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RoleAnnotationListener.
 */
class RoleAnnotationListener
{
    /**
     * The class name of the annotation, it has extracted
     * into a variable to make easier its extension.
     *
     * @var string
     */
    protected $annotationClass = 'Kreta\\Component\\Core\\Annotation\\Role';

    /**
     * The annotation reader.
     *
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $annotationReader;

    /**
     * The token storage.
     *
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $context;

    /**
     * Constructor.
     *
     * @param Reader                $reader  The annotation reader
     * @param TokenStorageInterface $context The token storage
     */
    public function __construct(Reader $reader, TokenStorageInterface $context)
    {
        $this->annotationReader = $reader;
        $this->context = $context;
    }

    /**
     * Listens when the annotation exists checking the user has role to execute this method.
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event The filter controller event
     */
    public function onRoleAnnotationMethod(FilterControllerEvent $event)
    {
        list($object, $method) = $event->getController();
        $reflectionClass = new \ReflectionClass(get_class($object));
        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass)) {
            foreach ($annotation->getRoles() as $role) {
                $method = sprintf('is%s', ucwords($role));
                if (method_exists($this, $method) && true === $this->$method()) {
                    return;
                };
            }
            throw new AccessDeniedException();
        }
    }

    /**
     * Checks if the user logged has role admin.
     *
     * @return bool
     */
    protected function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->context->getToken()->getUser()->getRoles(), true);
    }
}
