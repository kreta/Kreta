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

declare(strict_types=1);

namespace Kreta\IdentityAccess\Infrastructure\Symfony\Form\Type;

use BenGorUser\User\Application\Command\SignUp\ByInvitationSignUpUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType
{
    private $roles;
    private $token;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'options'         => ['translation_domain' => 'BenGorUser'],
                'invalid_message' => 'sign_up.form_password_invalid_message',
            ]);

        $this->roles = $options['roles'];
        $this->token = $options['invitation_token'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['roles', 'invitation_token']);
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class'      => ByInvitationSignUpUserCommand::class,
            'empty_data'      => function (FormInterface $form) {
                return new ByInvitationSignUpUserCommand(
                    $this->token,
                    $form->get('password')->getData(),
                    $this->roles
                );
            },
        ]);
    }
}
