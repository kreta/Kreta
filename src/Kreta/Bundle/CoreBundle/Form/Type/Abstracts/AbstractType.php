<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Form\Type\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType as BaseAbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Abstract class AbstractType.
 *
 * @package Kreta\Bundle\CoreBundle\Form\Type\Abstracts
 */
abstract class AbstractType extends BaseAbstractType
{
    /**
     * The data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * The factory.
     *
     * @var Object
     */
    protected $factory;

    /**
     * The object manager.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * The user.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface|null
     */
    protected $user = null;

    /**
     * Constructor.
     *
     * @param string                                                    $dataClass The data class
     * @param Object                                                    $factory   The factory
     * @param \Doctrine\Common\Persistence\ObjectManager                $manager   The manager
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $context   The security context
     */
    public function __construct($dataClass, $factory, ObjectManager $manager, SecurityContextInterface $context = null)
    {
        $this->dataClass = $dataClass;
        $this->factory = $factory;
        $this->manager = $manager;
        if ($context instanceof SecurityContextInterface) {
            $this->user = $context->getToken()->getUser();
            if (!($this->user instanceof UserInterface)) {
                throw new AccessDeniedException();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class'      => $this->dataClass,
            'empty_data'      => function (FormInterface $form) {
                return $this->createEmptyData($form);
            }
        ]);
    }

    /**
     * Method that encapsulates all the logic of build empty data.
     * It returns an instance of data class object.
     *
     * @param \Symfony\Component\Form\FormInterface $form The form
     *
     * @return Object
     */
    abstract protected function createEmptyData(FormInterface $form);
}
