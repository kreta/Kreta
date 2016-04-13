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

namespace Kreta\Component\Organization\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Participant form type class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('role', 'Kreta\Component\Organization\Form\Type\RoleType')
            ->add('user', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                'class'   => 'Kreta\Component\User\Model\User',
                'choices' => $options['users'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver
            ->setRequired(['organization'])
            ->setDefaults(['users' => []]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        $user = $form->get('user')->getData();
        if (!($user instanceof UserInterface)) {
            $user = $this->user;
        }

        return $this->factory->create($this->options['organization'], $user, $form->get('role')->getData());
    }
}
