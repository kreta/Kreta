<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Type\Api;

use Kreta\Bundle\CoreBundle\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LabelType.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Type\Api
 */
class LabelType extends AbstractType
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setRequired(['project']);
    }

    /**
     * {@inheritdoc}
     */
    public function createEmptyData(FormInterface $form)
    {
        return $this->factory->create($this->options['project'], $form->get('name')->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_label_type';
    }
}
