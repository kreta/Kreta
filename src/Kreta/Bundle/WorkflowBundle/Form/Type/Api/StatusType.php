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

use Finite\State\StateInterface;
use Kreta\Component\Workflow\Factory\StatusFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StatusType.
 *
 * @package Kreta\Bundle\WorkflowBundle\Form\Type\Api
 */
class StatusType extends AbstractType
{
    /**
     * The status factory.
     *
     * @var \Kreta\Component\Workflow\Factory\StatusFactory
     */
    protected $factory;

    /**
     * The workflow.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected $workflow;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Workflow\Factory\StatusFactory                   $statusFactory The status factory
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface|null $workflow      The workflow
     */
    public function __construct(StatusFactory $statusFactory, WorkflowInterface $workflow = null)
    {
        $this->factory = $statusFactory;
        $this->workflow = $workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', null)
            ->add('name', null)
            ->add('type', 'choice', [
                'required' => false,
                'choices'  => [
                    StateInterface::TYPE_INITIAL => 'initial',
                    StateInterface::TYPE_NORMAL  => 'normal',
                    StateInterface::TYPE_FINAL   => 'final'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Kreta\Component\Workflow\Model\Status',
            'csrf_protection'    => false,
            'empty_data'         => function (FormInterface $form) {
                if (!($type = $form->get('type')->getData())) {
                    return $this->factory->create($form->get('name')->getData(), $this->workflow, $type);
                }

                return $this->factory->create($form->get('name')->getData(), $this->workflow);
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
