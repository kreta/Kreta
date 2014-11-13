<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Form\Type;

use Kreta\Bundle\WebBundle\Form\Type\IssueType as BaseIssueType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class IssueType extends BaseIssueType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true
            ))
            ->add('description', 'textarea')
            ->add('type', new TypeType())
            ->add('priority', null)
            ->add('assignee', null, array(
                'class' => 'Kreta\Component\Core\Model\User',
                'choices' => $this->users,
                'property' => 'email'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
