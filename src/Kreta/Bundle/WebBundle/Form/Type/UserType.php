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
 * Class UserType.
 *
 * @package Kreta\Bundle\WebBundle\Form\Type
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array(
                'label' => 'First Name'
            ))
            ->add('lastName', null, array(
                'label' => 'Last Name'
            ))
            ->add('email', null, array(
                'label' => 'Email'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_core_user_type';
    }
}
