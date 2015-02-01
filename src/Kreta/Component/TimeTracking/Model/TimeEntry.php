<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\TimeTracking\Model;

use Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface;

/**
 * Class TimeEntry
 *
 * @package Kreta\Component\TimeTracking\Model
 */
class TimeEntry implements TimeEntryInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The datetime when the time entry was done.
     *
     * @var \DateTime
     */
    protected $dateReported;

    /**
     * An string describing what was done.
     *
     * @var string
     */
    protected $description;

    /**
     * Time spent in seconds.
     *
     * @var integer
     */
    protected $timeSpent;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateReported()
    {
        return $this->dateReported;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateReported(\DateTime $dateReported)
    {
        $this->dateReported = $dateReported;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }
} 
