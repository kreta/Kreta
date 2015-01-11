<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\ApiBundle\Form\Type\StatusTransitionType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;

/**
 * Class StatusTransitionHandler.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusTransitionHandler extends AbstractHandler
{
    /**
     * The status factory.
     *
     * @var \Kreta\Component\Workflow\Factory\StatusFactory
     */
    protected $factory;

    /**
     * The status repository.
     *
     * @var \Kreta\Component\Workflow\Repository\StatusRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory       The form factory
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager           The entity manage
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher   The event dispatcher
     * @param \Kreta\Component\Workflow\Factory\StatusTransitionFactory   $transitionFactory The transition factory
     * @param \Kreta\Component\Workflow\Repository\StatusRepository       $statusRepository  The status repository
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        StatusTransitionFactory $transitionFactory,
        StatusRepository $statusRepository
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->factory = $transitionFactory;
        $this->repository = $statusRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('workflow', $formOptions)) {
            throw new ParameterNotFoundException('workflow');
        }

        $workflow = $formOptions['workflow'];
        unset($formOptions['workflow']);

        return $this->formFactory->create(
            new StatusTransitionType($workflow, $this->factory, $this->repository), $object, $formOptions
        );
    }
}
