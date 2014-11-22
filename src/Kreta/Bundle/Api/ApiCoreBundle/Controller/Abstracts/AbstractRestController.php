<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Abstract Class AbstractRestController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts
 */
abstract class AbstractRestController extends FOSRestController
{
    /**
     * Abstract method that gets the entity repository class.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    abstract protected function getRepository();

    /**
     * Checks if user is authenticated returning this, otherwise throws an exception.
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return \Kreta\Component\Core\Model\Interfaces\UserInterface
     */
    protected function getCurrentUser()
    {
        if (!$this->getUser() instanceof UserInterface) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }

        return $this->getUser();
    }

    /**
     * Returns created view by data, groups, status code and format given
     *
     * @param mixed    $data       The data
     * @param string[] $groups     The groups, by default is null
     * @param int      $statusCode The HTTP status code, by default is 200
     * @param string   $format     The format of serializer by default is json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createResponse($data, $groups = null, $statusCode = 200, $format = 'json')
    {
        $view = View::create()
            ->setStatusCode($statusCode)
            ->setFormat($format)
            ->setData($data);
        if ($groups) {
            $view->setSerializationContext(SerializationContext::create()->setGroups($groups));
        }

        return $this->handleView($view);
    }

    /**
     * Returns all the errors from form into array.
     *
     * @param \Symfony\Component\Form\FormInterface $form The form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }

    /**
     * Returns all the resources, it admits ordering, filter, count and pagination.
     *
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher The param fetcher
     * @param string[]                             $groups       The array of serialization groups
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getAll(ParamFetcher $paramFetcher, $groups = array())
    {
        $resources = $this->getRepository()
            ->findAll(
                $paramFetcher->get('order'),
                $paramFetcher->get('q'),
                $paramFetcher->get('count'),
                $paramFetcher->get('page')
            );

        return $this->createResponse($resources, $groups);
    }

    /**
     * Returns all the resources if the user is authenticated, it admits ordering, count and pagination.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user         The user object
     * @param \FOS\RestBundle\Request\ParamFetcher                 $paramFetcher The param fetcher
     * @param string[]                                             $groups       The array of serialization groups
     * @param string                                               $query        The query, by default 'findAll'
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getAllAuthenticated(
        UserInterface $user,
        ParamFetcher $paramFetcher,
        $groups = array(),
        $query = 'findAll'
    )
    {
        $resources = $this->getRepository()
            ->$query(
                $user,
                $paramFetcher->get('order'),
                $paramFetcher->get('count'),
                $paramFetcher->get('page')
            );

        return $this->createResponse($resources, $groups);
    }

    /**
     * Returns the resource for given id if exists, otherwise throws the exception.
     *
     * @param string                         $id              The id of the resource
     * @param \Doctrine\ORM\EntityRepository $otherRepository The other repository
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return mixed
     */
    protected function getResourceIfExists($id, EntityRepository $otherRepository = null)
    {
        $repository = $otherRepository ? $otherRepository : $this->getRepository();
        $resource = $repository->find($id);
        if (!$resource) {
            throw new NotFoundHttpException('Does not exist any entity with ' . $id . ' id');
        }

        return $resource;
    }

    /**
     * Manage POST and PUT requests with logic of forms returning the response or form's validation errors.
     *
     * @param \Symfony\Component\Form\AbstractType $formType The form of resource object
     * @param mixed                                $resource The object of resource
     * @param string[]                             $groups   The serialization groups
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function manageForm(AbstractType $formType, $resource, $groups = array())
    {
        $request = $this->get('request');
        $form = $this->createForm(
            $formType,
            $resource,
            array('csrf_protection' => false, 'method' => $request->getMethod())
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($resource);
            $manager->flush();

            return $this->createResponse($resource, $groups);
        }

        return $this->createResponse($this->getFormErrors($form), null, 400);
    }

    /**
     * Gets the project if the current user is granted and if the project exists.
     *
     * @param string $id    The id
     * @param string $grant The grant, by default view
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    protected function getProjectIfAllowed($id, $grant = 'view')
    {
        $project = $this->getResourceIfExists($id, $this->get('kreta_core.repository_project'));
        if (!$this->get('security.context')->isGranted($grant, $project)) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }

        return $project;
    }
}
