<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\TimeTracking\Model\Interfaces;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;

/**
 * Interface TimeEntryInterface.
 *
 * @package Kreta\Component\TimeTracking\Model\Interfaces
 */
interface TimeEntryInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets date when time entry was made.
     *
     * @return \Datetime
     */
    public function getDateReported();

    /**
     * Sets date when time entry was made.
     *
     * @param \DateTime $dateReported The date reported
     *
     * @return $this self Object
     */
    public function setDateReported(\DateTime $dateReported);

    /**
     * Gets entry description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets entry description.
     *
     * @param string $description The description
     *
     * @return $this self Object
     */
    public function setDescription($description);

    /**
     * Gets issue.
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function getIssue();

    /**
     * Sets issue.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface $issue The issue
     *
     * @return $this self Object
     */
    public function setIssue(IssueInterface $issue);

    /**
     * Gets time spent in seconds.
     *
     * @return int
     */
    public function getTimeSpent();

    /**
     * Sets time spent in seconds.
     *
     * @param integer $timeSpent Seconds spent for the issue
     *
     * @return $this self Object
     */
    public function setTimeSpent($timeSpent);
}
