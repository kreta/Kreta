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

use Kreta\IdentityAccess\Application\Command\EditProfileCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    private $userId;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('image', FileType::class, [
                'error_bubbling' => false,
                'label'          => false,
                'mapped'         => false,
                'required'       => false,
            ]);

        $this->userId = $options['user_id'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('user_id');
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class'      => EditProfileCommand::class,
            'empty_data'      => function (FormInterface $form) {
                $image = $form->get('image')->getData();

                $imageName = null;
                $imageMimeType = null;
                $uploadedImage = null;
                if ($image instanceof UploadedFile) {
                    $imageName = $image->getClientOriginalName();
                    $uploadedImage = file_get_contents($image->getPathname());
                    $imageMimeType = $image->getMimeType();
                }

                return new EditProfileCommand(
                    $this->userId,
                    $form->get('email')->getData(),
                    $form->get('username')->getData(),
                    $form->get('firstName')->getData(),
                    $form->get('lastName')->getData(),
                    $imageName,
                    $imageMimeType,
                    $uploadedImage
                );
            },
        ]);
    }
}
