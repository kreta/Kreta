<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Form\Type\Api;

use Kreta\Component\Issue\Factory\IssueFactory;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueType.
 *
 * @package Kreta\Bundle\IssueBundle\Form\Type\Api
 */
class IssueType extends AbstractType
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The issue factory.
     *
     * @var \Kreta\Component\Issue\Factory\IssueFactory
     */
    protected $factory;

    /**
     * Collection of projects.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    protected $projects;

    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface[] $projects     Collection of projects
     * @param \Symfony\Component\Security\Core\SecurityContextInterface    $context      The context
     * @param \Kreta\Component\Issue\Factory\IssueFactory                  $issueFactory The issue factory
     */
    public function __construct(array $projects, SecurityContextInterface $context, IssueFactory $issueFactory)
    {
        $this->context = $context;
        $this->factory = $issueFactory;
        $this->projects = $projects;
    }

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
            ->add('type', new TypeType())
            ->add('priority', new PriorityType())
            ->add('project', 'entity', [
                'class'    => 'Kreta\Component\Project\Model\Project',
                'choices'  => $this->projects
            ]);

        $formModifier = function (FormInterface $form, ProjectInterface $project = null) {
            $participants = null === $project ? [] : $project->getParticipants();
            $users = [];
            foreach ($participants as $participant) {
                $users[] = $participant->getUser();
            }
            $this->project = $project;

            $form->add('assignee', 'entity', [
                'class'   => 'Kreta\Component\User\Model\User',
                'choices' => $users
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Issue\Model\Issue',
            'csrf_protection' => false,
            'empty_data'      => function () {
                $user = $this->context->getToken()->getUser();
                if (!($user instanceof UserInterface)) {
                    throw new \Exception('User is not logged');
                }

                return $this->factory->create($this->project, $user);
            }
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
