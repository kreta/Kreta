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

/**
 * Class ProjectType.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Type\Api
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
                'mapped' => false
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
        return $this->factory->create($this->user, $form->get('workflow')->getData());
    }
}
