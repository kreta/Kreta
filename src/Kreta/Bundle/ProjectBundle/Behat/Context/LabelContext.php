<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\ProjectBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class LabelContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LabelContext extends DefaultContext
{
    /**
     * Populates the database with labels.
     *
     * @param \Behat\Gherkin\Node\TableNode $labels The labels
     *
     *
     * @Given /^the following labels exist:$/
     */
    public function theFollowingLabelsExist(TableNode $labels)
    {
        foreach ($labels as $labelData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $labelData['project']], false);

            $label = $this->get('kreta_project.factory.label')->create($project, $labelData['name']);

            if (isset($labelData['id'])) {
                $this->setId($label, $labelData['id']);
            }

            $this->get('kreta_project.repository.label')->persist($label);
        }
    }
}
