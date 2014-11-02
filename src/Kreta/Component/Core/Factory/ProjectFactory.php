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

use Kreta\Component\Core\Factory\Abstracts\AbstractFactory;
use Kreta\Component\Core\Model\Project;
use Kreta\Component\Core\Model\Status;

/**
 * Class ProjectFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class ProjectFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $project = new Project();
        $statuses = $this->createDefaultStatus();
        foreach ($statuses as $status) {
            $project->addStatus($status);
        }

        return $project;
    }

    /**
     * Creates some default statuses to add into project when this is created.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    protected function createDefaultStatus()
    {
        $defaultStatusesNames = array('Todo', 'Doing', 'Done');

        $statuses = array();
        foreach ($defaultStatusesNames as $name) {
            $statuses[$name] = new Status($name);
        }

        $statuses['Todo']->setColor('#2c3e50');
        $statuses['Todo']->setType('initial');
        $statuses['Todo']->addStatusTransition($statuses['Doing']);
        $statuses['Todo']->addStatusTransition($statuses['Done']);

        $statuses['Doing']->setColor('#f1c40f');
        $statuses['Doing']->addStatusTransition($statuses['Todo']);
        $statuses['Doing']->addStatusTransition($statuses['Done']);

        $statuses['Done']->setColor('#1abc9c');
        $statuses['Done']->setType('final');
        $statuses['Done']->addStatusTransition($statuses['Todo']);
        $statuses['Done']->addStatusTransition($statuses['Doing']);

        return $statuses;
    }
}
