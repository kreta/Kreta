<?php
/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class IssueType
 */
class IssueType extends AbstractType
{
    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', null, array(
                'label' => 'Project'
            ))
            ->add('title', 'text', array(
                'required' => true,
                'label'    => 'Name',
            ))
            ->add('description', 'textarea', array(
                'label'    => 'Description',
            ))
            ->add('type', new TypeType(), array(
                'label'    => 'Type',
            ))
            ->add('priority', new PriorityType(), array(
                'label'    => 'Priority',
            ))
            ->add('status', null, array(
                'label'    => 'Status',
            ))
            ->add('reporter', null, array(
                'label'    => 'Assigner',
            ))
            ->add('assignee', null, array(
                'label'    => 'Assignee',
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'kreta_core_issue_type';
    }
}
