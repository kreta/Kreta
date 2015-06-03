<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class IssuePriorityType.
 *
 * @package Kreta\Component\Project\Form\Type
 */
class IssuePriorityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('name');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setRequired(['project']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_issue_priority_type';
    }

    /**
     * {@inheritdoc}
     */
    public function createEmptyData(FormInterface $form)
    {
        return $this->factory->create($this->options['project'], $form->get('name')->getData());
    }
}
