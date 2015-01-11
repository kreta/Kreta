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
use Kreta\Bundle\ApiBundle\Form\Type\WorkflowType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class WorkflowHandler.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Handler
 */
class WorkflowHandler extends AbstractHandler
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The workflow factory.
     *
     * @var \Kreta\Component\Workflow\Factory\WorkflowFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Symfony\Component\Security\Core\SecurityContextInterface   $context         The security context
     * @param \Kreta\Component\Workflow\Factory\WorkflowFactory           $workflowFactory The workflow factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        SecurityContextInterface $context,
        WorkflowFactory $workflowFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->context = $context;
        $this->factory = $workflowFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->create(new WorkflowType($this->context, $this->factory), $object, $formOptions);
    }
}
