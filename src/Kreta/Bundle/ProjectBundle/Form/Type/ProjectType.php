<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ProjectType.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Type
 */
class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                ['label' => 'Name']
            )
            ->add(
                'shortName',
                'text',
                ['label' => 'Short name', 'attr' => ['maxlength' => 4]]
            )
            ->add(
                'image',
                'file',
                ['label' => 'Image', 'required' => false, 'mapped' => false]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_project_type';
    }
}
