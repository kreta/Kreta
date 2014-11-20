<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class IssueFactory.
 *
 * @package Kreta\Component\Core\Factory
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
    public function __construct($className = '')
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of Issue.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project  Project that will contain the issue
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface    $reporter User that is creating the issue
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface
     */
    public function create(ProjectInterface $project, UserInterface $reporter)
    {
        $issue = new $this->className();
        $issue->setNumericId(count($project->getIssues()) + 1);
        $issue->setProject($project);
        $issue->setReporter($reporter);
        $issue->setAssignee($reporter);

        foreach ($project->getStatuses() as $status) {
            if ($status->getType() === 'initial') {
                $issue->setStatus($status);
                break;
            }
        }

        return $issue;
    }
}
