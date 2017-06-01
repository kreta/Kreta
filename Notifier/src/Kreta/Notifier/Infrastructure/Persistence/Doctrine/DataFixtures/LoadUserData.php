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

namespace Kreta\Notifier\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Notifier\Application\Command\Inbox\SignUpUserCommand;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\DataFixtures\AbstractFixture;
use Predis\Client;

class LoadUserData extends AbstractFixture
{
    protected $predis;

    protected function type() : string
    {
        return 'user';
    }

    public function getOrder() : int
    {
        return 1;
    }

    public function load(ObjectManager $manager) : void
    {
        $this->purgeDatabases();

        $i = 0;
        while ($i < $this->amount()) {
            $this->commandBus()->handle(
                new SignUpUserCommand(
                    $this->getRandomUserByIndex($i)
                )
            );
            ++$i;
        }
    }

    private function purgeDatabases() : void
    {
        $i = 0;
        while ($i < $this->amount()) {
            $this->redis()->del('events: ' . $this->getRandomUserByIndex($i));
            ++$i;
        }
    }

    private function redis() : Client
    {
        return $this->predis;
    }
}
