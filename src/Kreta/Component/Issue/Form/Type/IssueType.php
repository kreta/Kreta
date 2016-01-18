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

namespace Kreta\Component\Issue\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Kreta\Component\Project\Form\Type\LabelType;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Model\IssuePriority;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IssueType.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssueType extends AbstractType
{
    const PROJECT_INVALID_MESSAGE = 'This project is not valid so, assignee, priority and type will be invalid too.';

    /**
     * The label form type.
     *
     * @var \Kreta\Component\Project\Form\Type\LabelType
     */
    protected $labelType;

    /**
     * Constructor.
     *
     * @param string                     $dataClass        The data class
     * @param Object                     $factory          The factory
     * @param TokenStorageInterface|null $context          The security context
     * @param ObjectManager|null         $manager          The manager
     * @param array                      $validationGroups The validation groups
     * @param LabelType                  $labelType        The label form type
     */
    public function __construct(
        $dataClass,
        $factory,
        TokenStorageInterface $context = null,
        ObjectManager $manager = null,
        $validationGroups = [],
        LabelType $labelType
    ) {
        parent::__construct($dataClass, $factory, $context, $manager, $validationGroups);
        $this->labelType = $labelType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('description', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', [
                'required' => false,
            ])
            ->add('project', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                'class'           => 'Kreta\Component\Project\Model\Project',
                'choices'         => $options['projects'],
                'invalid_message' => self::PROJECT_INVALID_MESSAGE,
            ]);

        $formModifier = function (FormInterface $form, ProjectInterface $project = null) {
            $participants = null === $project ? [] : $project->getParticipants();
            $priorities = null === $project ? [] : $project->getIssuePriorities();
            $issues = null === $project ? [] : $project->getIssues();
            $users = [];
            foreach ($participants as $participant) {
                $users[] = $participant->getUser();
            }

            $form
                ->add('assignee', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                    'class'   => 'Kreta\Component\User\Model\User',
                    'choices' => $users,
                ])
                ->add('priority', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                    'class'   => 'Kreta\Component\Project\Model\IssuePriority',
                    'choices' => $priorities,
                ])
                ->add('parent', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                    'class'   => 'Kreta\Component\Issue\Model\Issue',
                    'choices' => $issues,
                ])
                ->add('labels', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', [
                    'entry_type'    => get_class($this->labelType),
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'delete_empty'  => true,
                    'entry_options' => ['project' => $project],
                ]);
        };

        $builder->get('project')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $project = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $project);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(['projects' => []]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        $priority = null === $form->get('priority')->getData()
            ? new IssuePriority()
            : $form->get('priority')->getData();

        return $this->factory->create(
            $this->user, $priority, $form->get('project')->getData(), $form->get('parent')->getData()
        );
    }
}
