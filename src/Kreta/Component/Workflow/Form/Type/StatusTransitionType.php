<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StatusTransitionType.
 *
 * @package Kreta\Component\Workflow\Form\Type
 */
class StatusTransitionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('name')
            ->add('state', 'entity', [
                'class'   => 'Kreta\Component\Workflow\Model\Status',
                'choices' => $options['workflow']->getStatuses(),
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
        parent::setDefaultOptions($resolver);
        $resolver->setRequired(['workflow']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_workflow_status_transition_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create(
            $form->get('name')->getData(),
            $form->get('state')->getData(),
            $this->manager->getRepository('Kreta\Component\Workflow\Model\Status')->findByIds(
                $form->get('initials')->getData(), $this->options['workflow']
            )
        );
    }
}
