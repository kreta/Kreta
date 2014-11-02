<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\WebBundle\Form\Type
 */
class IssueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', array(
                'label'    => 'Project',
                'class'    => 'Kreta\Component\Core\Model\Project',
                'property' => 'name'
            ))
            ->add('title', 'text', array(
                'required' => true,
                'label'    => 'Name'
            ))
            ->add('description', 'textarea', array(
                'label' => 'Description'
            ))
            ->add('type', new TypeType(), array(
                'label' => 'Type'
            ))
            ->add('priority', new PriorityType(), array(
                'label' => 'Priority'
            ))
            ->add('status', 'entity', array(
                'label'    => 'Status',
                'class'    => 'Kreta\Component\Core\Model\Status',
                'property' => 'name'
            ))
            ->add('assignee', null, array(
                'label'       => 'Assignee',
                'empty_value' => null
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_core_issue_type';
    }
}
