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

declare(strict_types=1);

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;

class LoadProjectData extends AbstractFixture
{
    protected function type() : string
    {
        return 'project';
    }

    public function getOrder() : int
    {
        return 3;
    }

    public function load(ObjectManager $manager) : void
    {
        $i = 0;
        while ($i < $this->amount()) {
            $this->queryBus()->handle(
                new FilterOrganizationsQuery(
                    $this->getRandomUserByIndex($i),
                    0,
                    1
                ),
                $organizations
            );

            if (empty($organizations)) {
                ++$i;
                continue;
            }

            $this->commandBus()->handle(
                new CreateProjectCommand(
                    'Project ' . $i,
                    $organizations[0]['id'],
                    $organizations[0]['owners'][0]['id'],
                    $this->fakeIds()[$i]
                )
            );
            ++$i;
        }
    }
}
