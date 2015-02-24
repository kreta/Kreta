<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Bundle\TimeTrackingBundle\Form\Type\TimeEntryType;
use Kreta\Component\TimeTracking\Factory\TimeEntryFactory;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;

/**
 * Class TimeEntryHandler.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Form\Handler
 */
class TimeEntryHandler extends AbstractHandler
{
    /**
     * The issue factory.
     *
     * @var \Kreta\Component\Issue\Factory\IssueFactory
     */
    protected $factory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory      Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager          Persists and flush object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher  Dispatches FormHandlerEvents
     * @param \Kreta\Component\TimeTracking\Factory\TimeEntryFactory      $timeEntryFactory The time entry factory
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        TimeEntryFactory $timeEntryFactory
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->factory = $timeEntryFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        if (!array_key_exists('issue', $formOptions)) {
            throw new ParameterNotFoundException('issue');
        }

        $issue = $formOptions['issue'];
        unset($formOptions['issue']);

        return $this->formFactory->create(new TimeEntryType($issue, $this->factory), $object, $formOptions);
    }
}
