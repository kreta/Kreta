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

namespace Kreta\Component\Workflow\Form\Type;

use Finite\State\StateInterface;
use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StatusType.
 *
 * @package Kreta\Component\Workflow\Form\Type
 */
class StatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('color')
            ->add('name')
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
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setOptional(['workflow']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_workflow_status_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create(
            $form->get('name')->getData(), $this->options['workflow'], $form->get('type')->getData()
        );
    }
}
