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
use Kreta\Bundle\ApiBundle\Form\Type\StatusType;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Component\Workflow\Factory\StatusFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;

/**
 * Class StatusHandler.
 *
 * @package Kreta\Bundle\ApiBundle\Form\Handler
 */
class StatusHandler extends AbstractHandler
{
    /**
     * The status factory.
     *
     * @var \Kreta\Component\Workflow\Factory\StatusFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Kreta\Component\Workflow\Factory\StatusFactory             $statusFactory   The status factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        StatusFactory $statusFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->factory = $statusFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($status = null, array $formOptions = [])
    {
        $workflow = null;
        if (!($status instanceof StatusInterface)) {
            if (!array_key_exists('workflow', $formOptions)) {
                throw new ParameterNotFoundException('workflow');
            }

            $workflow = $formOptions['workflow'];
            unset($formOptions['workflow']);
        }

        return $this->formFactory->create(new StatusType($this->factory, $workflow), $status, $formOptions);
    }
}
