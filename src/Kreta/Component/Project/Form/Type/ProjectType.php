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

namespace Kreta\Component\Project\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class ProjectType.
 *
 * @package Kreta\Component\Project\Form\Type
 */
class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortName')
            ->add('image', 'file', [
                'required' => false,
                'mapped'   => false
            ])
            ->add('workflow', 'entity', [
                'class'    => 'Kreta\Component\Workflow\Model\Workflow',
                'required' => false,
                'mapped'   => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_project_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create(
            $this->user, $form->get('workflow')->getData(), true, $form->get('image')->getData()
        );
    }
}
