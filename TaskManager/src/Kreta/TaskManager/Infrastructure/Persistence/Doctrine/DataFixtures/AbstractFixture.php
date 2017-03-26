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

use Doctrine\Common\DataFixtures\AbstractFixture as BaseAbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Application\QueryBus;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractFixture extends BaseAbstractFixture implements OrderedFixtureInterface
{
    protected $commandBus;
    protected $queryBus;

    abstract protected function type() : string;

    protected function commandBus() : CommandBus
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
                __DIR__ . '/../DataFixtures/FakeData/' . $this->type() . '_ids.yml'
            )
        );
    }

    protected function amount() : int
    {
        return count($this->fakeIds());
    }

    protected function getRandomByIndex($index, array $list = null) : string
    {
        $list = null === $list ? $this->fakeIds() : $list;

        $numberOfUserIds = count($list);
        $j = $this->mod($index, $numberOfUserIds - 1) > $numberOfUserIds
            ? 0
            : $this->mod(($numberOfUserIds - ($index - 1)), $numberOfUserIds);

        return $list[$j];
    }

    protected function getRandomUserByIndex($index) : string
    {
        $userIds = Yaml::parse(
            file_get_contents(
                __DIR__ . '/../DataFixtures/FakeData/user_ids.yml'
            )
        );

        return $this->getRandomByIndex($index, $userIds);
    }

    private function mod($first, $second)
    {
        $result = $first % $second;

        return $result < 0 ? $result + $second : $result;
    }

}
