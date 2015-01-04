<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Form\Type;

use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class WorkflowType.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Type
 */
class WorkflowType extends AbstractType
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The workflow factory.
     *
     * @var \Kreta\Component\Workflow\Factory\WorkflowFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $context         The context
     * @param \Kreta\Component\Workflow\Factory\WorkflowFactory         $workflowFactory The workflow factory
     */
    public function __construct(SecurityContextInterface $context, WorkflowFactory $workflowFactory)
    {
        $this->context = $context;
        $this->factory = $workflowFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Workflow\Model\Workflow',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                $user = $this->context->getToken()->getUser();
                if (!($user instanceof UserInterface)) {
                    throw new \Exception('User is not logged');
                }
                return $this->factory->create($form->get('name')->getData(), $user, true);
            }
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
