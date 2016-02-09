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
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
            ->add('image', 'Symfony\Component\Form\Extension\Core\Type\FileType', [
                'required' => false,
                'mapped'   => false,
            ])
            ->add('workflow', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                'class'    => 'Kreta\Component\Workflow\Model\Workflow',
                'required' => false,
                'mapped'   => false,
            ])
            ->add('organization', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                'class'    => 'Kreta\Component\Organization\Model\Organization',
                'required' => false,
                'mapped'   => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create(
            $this->user,
            $form->get('organization')->getData(),
            $form->get('workflow')->getData(),
            true,
            $form->get('image')->getData()
        );
    }
}
