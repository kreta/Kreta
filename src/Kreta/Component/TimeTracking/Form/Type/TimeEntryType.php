<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\TimeTracking\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TimeEntryType.
 *
 * @package Kreta\Component\TimeTracking\Form\Type
 */
class TimeEntryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('description', 'textarea', ['required' => false])
            ->add('timeSpent', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setRequired(['issue']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_time_tracking_time_entry_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create($this->options['issue']);
    }
}
