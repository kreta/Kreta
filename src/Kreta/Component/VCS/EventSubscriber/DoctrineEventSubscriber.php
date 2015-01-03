<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kreta\Component\VCS\Event\NewBranchEvent;
use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class DoctrineEventSubscriber
 *
 * @package Kreta\Component\VCS\EventSubscriber
 */
class DoctrineEventSubscriber implements EventSubscriber
{
    /**
     * @var EventDispatcher $dispatcher
     */
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    /**
     * Handles postPersist event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof CommitInterface) {
            $this->dispatcher->dispatch(NewCommitEvent::NAME, new NewCommitEvent($args->getObject()));
        } else if ($args->getObject() instanceof BranchInterface) {
            $this->dispatcher->dispatch(NewBranchEvent::NAME, new NewBranchEvent($args->getObject()));
        }
    }
}
