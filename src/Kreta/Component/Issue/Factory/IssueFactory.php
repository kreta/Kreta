<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Issue\Factory;

use Kreta\Component\Project\Model\Interfaces\IssueTypeInterface;
use Kreta\Component\Project\Model\Interfaces\PriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class IssueFactory.
 *
 * @package Kreta\Component\Issue\Factory
 */
class IssueFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of issue.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface            $reporter User that is creating the issue
     * @param \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface    $type     The issue type
     * @param \Kreta\Component\Project\Model\Interfaces\PriorityInterface     $priority The priority
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface|null $project  The project
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function create(
        UserInterface $reporter,
        IssueTypeInterface $type,
        PriorityInterface $priority,
        ProjectInterface $project = null
    )
    {
        $issue = new $this->className();

        if ($project instanceof ProjectInterface) {
            $issue->setProject($project);
            $statuses = $project->getWorkflow()->getStatuses();
            foreach ($statuses as $status) {
                if ($status->getType() === 'initial') {
                    $issue->setStatus($status);
                    break;
                }
            }
        }

        return $issue
            ->setPriority($priority)
            ->setType($type)
            ->setReporter($reporter)
            ->setAssignee($reporter);
    }
}
