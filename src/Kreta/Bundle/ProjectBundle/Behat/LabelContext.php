<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class LabelContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class LabelContext extends DefaultContext
{
    /**
     * Populates the database with labels.
     *
     * @param \Behat\Gherkin\Node\TableNode $labels The labels
     *
     * @return void
     *
     * @Given /^the following labels exist:$/
     */
    public function theFollowingLabelsExist(TableNode $labels)
    {
        $this->getManager();
        foreach ($labels as $labelData) {
            $project = $this->getContainer()->get('kreta_project.repository.project')
                ->findOneBy(['name' => $labelData['project']]);

            $label = $this->getContainer()->get('kreta_project.factory.label')
                ->create($project, $labelData['name']);

            if (isset($labelData['id'])) {
                $this->setId($label, $labelData['id']);
            }

            $this->manager->persist($label);
        }

        $this->manager->flush();
    }
}
