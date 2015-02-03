<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WorkflowBundle\Form\Type\Api;

use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StatusTransitionType.
 *
 * @package Kreta\Bundle\WorkflowBundle\Form\Type\Api
 */
class StatusTransitionType extends AbstractType
{
    /**
     * The status transition factory.
     *
     * @var \Kreta\Component\Workflow\Factory\StatusTransitionFactory
     */
    protected $factory;

    /**
     * The status repository.
     *
     * @var \Kreta\Component\Workflow\Repository\StatusRepository
     */
    protected $repository;

    /**
     * Array which contains statuses.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    protected $statuses;

    /**
     * The status transition's workflow.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected $workflow;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow          The workflow
     * @param \Kreta\Component\Workflow\Factory\StatusTransitionFactory    $transitionFactory The transition factory
     * @param \Kreta\Component\Workflow\Repository\StatusRepository        $statusRepository  The status repository
     */
    public function __construct(
        WorkflowInterface $workflow,
        StatusTransitionFactory $transitionFactory,
        StatusRepository $statusRepository
    )
    {
        $this->workflow = $workflow;
        $this->factory = $transitionFactory;
        $this->statuses = $workflow->getStatuses();
        $this->repository = $statusRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('state', 'entity', [
                'class'   => 'Kreta\Component\Workflow\Model\Status',
                'choices' => $this->statuses,
            ])
            ->add('initials', null, [
                'mapped' => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Workflow\Model\StatusTransition',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                return $this->factory->create(
                    $form->get('name')->getData(),
                    $form->get('state')->getData(),
                    $this->repository->findByIds($form->get('initials')->getData(), $this->workflow)
                );
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
