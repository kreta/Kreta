<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\TimeTracking\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;

/**
 * Class TimeTrackingFactory.
 *
 * @package Kreta\Component\TimeTracking\Factory
 */
class TimeEntryFactory
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
     * Creates an instance of a time entry.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return \Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface
     */
    public function create(IssueInterface $issue)
    {
        $timeEntry = new $this->className;

        return $timeEntry
            ->setDateReported(new \DateTime())
            ->setIssue($issue);
    }
}
