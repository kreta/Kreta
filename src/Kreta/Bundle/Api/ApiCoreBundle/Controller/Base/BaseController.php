<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Controller\Base;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * Class BaseController.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Controller\Base
 */
class BaseController extends FOSRestController
{
    /**
     * Checks if user is authenticated returning this, otherwise throws an exception.
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return \Kreta\Component\Core\Model\Interfaces\UserInterface
     */
    public function getCurrentUser()
    {
        if ($this->getUser() instanceof UserInterface === false) {
            throw new AccessDeniedException('Not allowed to access this resource');
        }

        return $this->getUser();
    }

    /**
     * Returns created view by data, groups, status code and format given
     *
     * @param mixed        $data       The data
     * @param array|string $groups     The groups, by default is null
     * @param int          $statusCode The HTTP status code, by default is 200
     * @param string       $format     The format of serializer by default is json
     *
     * @return \FOS\RestBundle\View\View
     */
    protected function createView($data, $groups = null, $statusCode = 200, $format = 'json')
    {
        $view = View::create()
            ->setStatusCode($statusCode)
            ->setFormat($format)
            ->setData($data);
        if ($groups !== null) {
            $view->setSerializationContext(SerializationContext::create()->setGroups($groups));
        }

        return $view;
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
            if ($child->isValid() === false) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }
}
