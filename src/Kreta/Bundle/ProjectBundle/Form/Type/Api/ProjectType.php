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
    protected function createEmptyData(FormInterface $form)
    {
        $workflowId = $form->get('workflow')->getData() ? $form->get('workflow')->getData() : 'non-exist-id';
        $workflow = $this->manager->getRepository('Kreta\Component\Workflow\Model\Workflow')->find($workflowId);

        return $this->factory->create($this->user, $workflow);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_project_type';
    }
}
