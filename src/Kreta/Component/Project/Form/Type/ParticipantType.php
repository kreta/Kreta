<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ParticipantType.
 *
 * @package Kreta\Component\Project\Form\Type
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
            ->add('role', 'kreta_project_role_type')
            ->add('user', 'entity', [
                'class'   => 'Kreta\Component\User\Model\User',
                'choices' => $options['users']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver
            ->setRequired(['project'])
            ->setDefaults(['users' => []]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kreta_project_participant_type';
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
        return $this->factory->create($this->options['project'], $user, $form->get('role')->getData());
    }
}
