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

use BenGorFile\File\Infrastructure\CommandBus\FileCommandBus;
use BenGorFile\FileBundle\Form\Type\FileType;
use Kreta\IdentityAccess\Application\Command\EditProfileCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    private $userId;
    private $commandBus;

    public function __construct(FileCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('image', FileType::class);

        $this->userId = $options['user_id'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('user_id');
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class'      => EditProfileCommand::class,
            'empty_data'      => function (FormInterface $form) {
                $command = $form->get('image')->getData();
                $this->commandBus->handle($command);

                return new EditProfileCommand(
                    $this->userId,
                    $form->get('email')->getData(),
                    $form->get('username')->getData(),
                    $form->get('firstName')->getData(),
                    $form->get('lastName')->getData(),
                    $command->id()
                );
            },
        ]);
    }
}
