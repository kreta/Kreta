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
