<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Controller\Abstracts;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract Class AbstractRestController.
 *
 * @package Kreta\Bundle\ApiBundle\Controller\Abstracts
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
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    protected function getCurrentUser()
    {
        if (!$this->getUser() instanceof UserInterface) {
            throw new AccessDeniedHttpException('Not allowed to access this resource');
        }

        return $this->getUser();
    }

    /**
     * Returns created view by data, groups, status code and format given
     *
     * @param mixed    $data       The data
     * @param string[] $groups     The groups, by default is null
     * @param int      $statusCode The HTTP status code, by default
     * @param string   $format     The format of serializer by default is json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createResponse($data, $groups = null, $statusCode = Codes::HTTP_OK, $format = 'json')
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
        $errors = [];
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
     * Returns all the resources if the user is authenticated, it admits ordering, count and pagination.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user         The user object
     * @param \FOS\RestBundle\Request\ParamFetcher                 $paramFetcher The param fetcher
     * @param string[]                                             $groups       The array of serialization groups
     * @param string                                               $query        The query, by default 'findAll'
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getAll(
        UserInterface $user,
        ParamFetcher $paramFetcher,
        $groups = [],
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
     * Processes POST requests.
     *
     * @param \Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler $formHandler The form handler
     * @param mixed                                                           $resource    The object of resource
     * @param string[]                                                        $groups      The serialization groups
     * @param array                                                           $formOptions Array which contains the
     *                                                                                     form options
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function post(
        AbstractHandler $formHandler,
        $resource,
        array $groups = [],
        array $formOptions = ['csrf_protection' => false, 'method' => 'POST']
    )
    {
        return $this->processFormRequest($formHandler, $formOptions, $resource, $groups, Codes::HTTP_CREATED);
    }

    /**
     * Processes PUT requests.
     *
     * @param \Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler $formHandler The form handler
     * @param mixed                                                           $resource    The object of resource
     * @param string[]                                                        $groups      The serialization groups
     * @param array                                                           $formOptions Array which contains the
     *                                                                                     form options
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function put(
        AbstractHandler $formHandler,
        $resource,
        array $groups = [],
        array $formOptions = ['csrf_protection' => false, 'method' => 'PUT']
    )
    {
        return $this->processFormRequest($formHandler, $formOptions, $resource, $groups, Codes::HTTP_OK);
    }

    /**
     * Processes form requests (POST and PUT requests) returning the response or form's validation errors.
     *
     * @param \Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler $formHandler The form handler
     * @param array                                                           $formOptions Array which contains the
     *                                                                                     form options
     * @param mixed                                                           $resource    The object of resource
     * @param string[]                                                        $groups      The serialization groups
     * @param int                                                             $statusCode  The http status code,
     *                                                                                     by default 200
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processFormRequest(
        AbstractHandler $formHandler,
        array $formOptions = [],
        $resource,
        array $groups = [],
        $statusCode = Codes::HTTP_OK
    )
    {
        $form = $formHandler->handleForm($this->get('request'), $resource, $formOptions);

        if ($form->isValid()) {
            return $this->createResponse($resource, $groups, $statusCode);
        }

        return $this->createResponse($this->getFormErrors($form), null, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * Gets the project if the current user is granted and if the project exists.
     *
     * @param string $projectId    The project id
     * @param string $projectGrant The project grant, by default view
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected function getProjectIfAllowed($projectId, $projectGrant = 'view')
    {
        $project = $this->get('kreta_project.repository.project')->find($projectId, false);

        if (!$this->get('security.context')->isGranted($projectGrant, $project)) {
            throw new AccessDeniedHttpException('Not allowed to access this resource');
        }

        return $project;
    }

    /**
     * Gets the workflow if the current user is granted and if the workflow exists.
     *
     * @param string $workflowId    The workflow id
     * @param string $workflowGrant The workflow grant, by default view
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected function getWorkflowIfAllowed($workflowId, $workflowGrant = 'view')
    {
        $workflow = $this->get('kreta_workflow.repository.workflow')->find($workflowId, false);

        if (!$this->get('security.context')->isGranted($workflowGrant, $workflow)) {
            throw new AccessDeniedHttpException('Not allowed to access this resource');
        }

        return $workflow;
    }
}
