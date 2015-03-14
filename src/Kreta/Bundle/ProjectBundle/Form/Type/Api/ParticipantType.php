<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Type\Api;

use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ParticipantType.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Type\Api
 */
class ParticipantType extends AbstractType
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The project factory.
     *
     * @var \Kreta\Component\Project\Factory\ParticipantFactory
     */
    protected $factory;

    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * Collection that contains the users.
     *
     * @var \Kreta\Component\User\Model\User[]
     */
    protected $users;

    /**
     * The user repository.
     *
     * @var \Kreta\Component\User\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface  $context            The security context
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project            The project
     * @param \Kreta\Component\Project\Factory\ParticipantFactory        $participantFactory Participant factory
     * @param \Kreta\Component\User\Repository\UserRepository            $userRepository     The user repository
     */
    public function __construct(
        SecurityContextInterface $context,
        ProjectInterface $project,
        ParticipantFactory $participantFactory,
        UserRepository $userRepository
    )
    {
        $this->context = $context;
        $this->project = $project;
        $this->factory = $participantFactory;
        $this->userRepository = $userRepository;
        $this->users = $userRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', new RoleType())
            ->add('user', 'entity', [
                'class'   => 'Kreta\Component\User\Model\User',
                'choices' => $this->users
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => 'Kreta\Component\Project\Model\Participant',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                $userId = $form->get('user')->getData() ? $form->get('user')->getData() : 'non-exist-id';
                $user = $this->userRepository->find($userId);
                if (!($user instanceof UserInterface)) {
                    $user = $this->context->getToken()->getUser();
                    if (!($user instanceof UserInterface)) {
                        throw new \Exception('User is not logged');
                    }
                }

                return $this->factory->create($this->project, $user, $form->get('role')->getData());
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
