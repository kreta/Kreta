<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Issue\Form\Type;

use Kreta\Component\Core\Form\Type\Abstracts\AbstractType;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Model\IssuePriority;
use Kreta\Component\Project\Model\IssueType as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class IssueType.
 *
 * @package Kreta\Component\Issue\Form\Type
 */
class IssueType extends AbstractType
{
    const PROJECT_INVALID_MESSAGE = 'This project is not valid so, assignee, priority and type will be invalid too.';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea', [
                'required' => false,
            ])
            ->add('project', 'entity', [
                'class'           => 'Kreta\Component\Project\Model\Project',
                'choices'         => $options['projects'],
                'invalid_message' => self::PROJECT_INVALID_MESSAGE
            ]);

        $formModifier = function (FormInterface $form, ProjectInterface $project = null) {
            $participants = null === $project ? [] : $project->getParticipants();
            $types = null === $project ? [] : $project->getIssueTypes();
            $priorities = null === $project ? [] : $project->getIssuePriorities();
            $issues = null === $project ? [] : $project->getIssues();
            $users = [];
            foreach ($participants as $participant) {
                $users[] = $participant->getUser();
            }

            $form
                ->add('assignee', 'entity', [
                    'class'   => 'Kreta\Component\User\Model\User',
                    'choices' => $users
                ])
                ->add('priority', 'entity', [
                    'class'   => 'Kreta\Component\Project\Model\IssuePriority',
                    'choices' => $priorities
                ])
                ->add('parent', 'entity', [
                    'class'   => 'Kreta\Component\Issue\Model\Issue',
                    'choices' => $issues
                ])
                ->add('type', 'entity', [
                    'class'   => 'Kreta\Component\Project\Model\IssueType',
                    'choices' => $types
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
    public function getName()
    {
        return 'kreta_issue_issue_type';
    }

    /**
     * {@inheritdoc}
     */
    protected function createEmptyData(FormInterface $form)
    {
        $type = null === $form->get('type')->getData()
            ? new Type()
            : $form->get('type')->getData();
        $priority = null === $form->get('priority')->getData()
            ? new IssuePriority()
            : $form->get('priority')->getData();

        return $this->factory->create(
            $this->user, $type, $priority, $form->get('project')->getData(), $form->get('parent')->getData()
        );
    }
}
