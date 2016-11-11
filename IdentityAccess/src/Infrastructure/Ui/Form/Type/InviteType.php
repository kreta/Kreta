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

declare(strict_types = 1);

namespace Kreta\IdentityAccess\Infrastructure\Ui\Form\Type;

use BenGorUser\User\Application\Command\Invite\InviteUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InviteType extends AbstractType
{
    private $roles;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class);

        $this->roles = $options['roles'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['roles']);
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class'      => InviteUserCommand::class,
            'empty_data'      => function (FormInterface $form) {
                return new InviteUserCommand(
                    $form->get('email')->getData(),
                    $this->roles
                );
            },
        ]);
    }
}
