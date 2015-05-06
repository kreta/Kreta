<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class TimeEntryContext.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Behat
 */
class TimeEntryContext extends DefaultContext
{
    /**
     * Populates the database with time entries.
     *
     * @param \Behat\Gherkin\Node\TableNode $timeEntries The time entries
     *
     * @return void
     *
     * @Given /^the following time entries exist:$/
     */
    public function theFollowingTimeEntriesExist(TableNode $timeEntries)
    {
        foreach ($timeEntries as $timeEntryData) {
            $issue = $this->get('kreta_issue.repository.issue')
                ->findOneBy(['title' => $timeEntryData['issue']], false);

            $timeEntry = $this->get('kreta_time_tracking.factory.time_entry')->create($issue);
            $timeEntry
                ->setDescription($timeEntryData['description'])
                ->setTimeSpent($timeEntryData['timeSpent']);
            if (isset($timeEntryData['dateReported'])) {
                $this->setField($timeEntry, 'dateReported', new \DateTime($timeEntryData['dateReported']));
            }
            if (isset($timeEntryData['id'])) {
                $this->setId($timeEntry, $timeEntryData['id']);
            }

            $this->get('kreta_time_tracking.repository.time_entry')->persist($timeEntry);
        }
    }
}
