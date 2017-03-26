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
use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationCommand;

class LoadOrganizationData extends AbstractFixture
{
    protected function type() : string
    {
        return 'organization';
    }

    public function getOrder() : int
    {
        return 2;
    }

    public function load(ObjectManager $manager) : void
    {
        $i = 0;
        $memberIds = [];
        while ($i < $this->amount()) {
            $ownerId = $this->getRandomUserByIndex($i);
            $command = new CreateOrganizationCommand(
                $ownerId,
                'Organization ' . $i,
                $this->fakeIds()[$i]
            );
            $memberIds[] = $ownerId;

            $this->commandBus()->handle($command);

            $iterations = $i % 5 > 6 ? 0 : 5 - $i % 6;
            $j = 0;
            while ($j < $iterations) {
                $memberId = $this->getRandomUserByIndex($j);
                if (in_array($memberId, $memberIds, true)) {
                    ++$j;
                    continue;
                }

                $this->commandBus()->handle(
                    new AddOrganizationMemberToOrganizationCommand(
                        $memberId,
                        $command->id(),
                        $ownerId
                    )
                );
                ++$j;
                $memberIds[] = $memberId;
            }
            $memberIds = [];
            ++$i;
        }
    }
}
