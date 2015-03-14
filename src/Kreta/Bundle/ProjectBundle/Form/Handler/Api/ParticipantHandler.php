<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Bundle\ProjectBundle\Form\Type\Api\ParticipantType;
use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\User\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ParticipantHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class ParticipantHandler extends AbstractHandler
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The participant factory.
     *
     * @var \Kreta\Component\Project\Factory\ParticipantFactory
     */
    protected $factory;

    /**
     * The user repository.
     *
     * @var \Kreta\Component\User\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory        The form factory
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager            The manager
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher    The event dispatcher
     * @param \Symfony\Component\Security\Core\SecurityContextInterface   $context            The security context
     * @param \Kreta\Component\Project\Factory\ParticipantFactory         $participantFactory The participant factory
     * @param \Kreta\Component\User\Repository\UserRepository             $userRepository     The user repository
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        ParticipantFactory $participantFactory,
        UserRepository $userRepository
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->context = $context;
        $this->factory = $participantFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('project', $formOptions)) {
            throw new ParameterNotFoundException('project');
        }

        $project = $formOptions['project'];
        unset($formOptions['project']);

        return $this->formFactory->create(
            new ParticipantType($this->context, $project, $this->factory, $this->userRepository), $object, $formOptions
        );
    }
}
