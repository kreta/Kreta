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

namespace Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseAbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Domain\Model\Exception;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractFixture extends BaseAbstractFixture implements OrderedFixtureInterface
{
    protected $commandBus;
    protected $queryBus;

    abstract protected function type() : string;

    // It does not possible enable this return type because IdentityAccess,
    // uses the BenGorUser so, the command bus is not a shared kernel's
    // command bus instance.
    protected function commandBus() // : \Kreta\SharedKernel\Application\CommandBus
    {
        return $this->commandBus;
    }

    protected function queryBus() : QueryBus
    {
        return $this->queryBus;
    }

    protected function fakeIds() : array
    {
        return Yaml::parse(
            file_get_contents(
                $this->fakeDataDir() . '/' . $this->type() . '_ids.yml'
            )
        );
    }

    protected function amount() : int
    {
        return count($this->fakeIds());
    }

    protected function getRandomByIndex(int $index, array $list = null) : string
    {
        $list = null === $list ? $this->fakeIds() : $list;

        $numberOfUserIds = count($list);
        $j = $this->mod($index, $numberOfUserIds - 1) > $numberOfUserIds
            ? 0
            : $this->mod(($numberOfUserIds - ($index - 1)), $numberOfUserIds);

        return $list[$j];
    }

    protected function getRandomUserByIndex(int $index) : string
    {
        $userIds = Yaml::parse(
            file_get_contents(
                __DIR__ . '/../DataFixtures/FakeData/user_ids.yml'
            )
        );

        return $this->getRandomByIndex($index, $userIds);
    }

    private function mod(int $first, int $second) : int
    {
        $result = $first % $second;

        return $result < 0 ? $result + $second : $result;
    }

    private function fakeDataDir() : string
    {
        $baseDir = __DIR__ . '/../../../../../../../../../../src/Kreta' .
            '/%s/Infrastructure/Persistence/Doctrine/DataFixtures/FakeData';

        $identityAccessDir = sprintf($baseDir, 'IdentityAccess');
        $taskManagerDir = sprintf($baseDir, 'TaskManager');
        $notifierDir = sprintf($baseDir, 'Notifier');

        if ($this->type() === 'user') {
            return __DIR__ . '/../DataFixtures/FakeData';
        }
        if (is_dir($identityAccessDir)) {
            return $identityAccessDir;
        }
        if (is_dir($taskManagerDir)) {
            return $taskManagerDir;
        }
        if (is_dir($notifierDir)) {
            return $notifierDir;
        }
        throw new Exception('The identity access and task manager fake data dirs are not valid');
    }
}
