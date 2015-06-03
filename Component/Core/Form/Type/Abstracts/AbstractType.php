<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Form\Type\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType as BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Abstract class AbstractType.
 *
 * @package Kreta\Component\Core\Form\Type\Abstracts
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
     * The validation groups.
     *
     * @var array
     */
    protected $validationGroups;

    /**
     * The object manager.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Array that contains the form options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The user.
     *
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface|null
     */
    protected $user = null;

    /**
     * Constructor.
     *
     * @param string                     $dataClass        The data class
     * @param Object                     $factory          The factory
     * @param TokenStorageInterface|null $context          The security context
     * @param ObjectManager|null         $manager          The manager
     * @param array                      $validationGroups The validation groups
     */
    public function __construct(
        $dataClass,
        $factory,
        TokenStorageInterface $context = null,
        ObjectManager $manager = null,
        $validationGroups = []
    )
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
        $this->factory = $factory;
        $this->manager = $manager;
        if ($context instanceof TokenStorageInterface) {
            $this->user = $context->getToken()->getUser();
            if (!($this->user instanceof UserInterface)) {
                throw new AccessDeniedException();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'data_class'        => $this->dataClass,
            'validation_groups' => $this->validationGroups,
            'empty_data'        => function (FormInterface $form) {
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
