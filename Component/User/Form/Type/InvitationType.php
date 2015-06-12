<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\User\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class InvitationType.
 *
 * @package Kreta\Component\User\Form\Type
 */
class InvitationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('username');
        $builder->add('firstName');
        $builder->add('lastName');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_user_invitation_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        return $this->factory->create(
            $form->get('email')->getData(),
            $form->get('username')->getData(),
            $form->get('firstName')->getData(),
            $form->get('lastName')->getData()
        );
    }
}
