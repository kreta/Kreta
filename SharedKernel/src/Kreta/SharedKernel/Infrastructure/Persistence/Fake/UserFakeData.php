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

namespace Kreta\SharedKernel\Infrastructure\Persistence\Fake;

use Symfony\Component\Yaml\Yaml;

final class UserFakeData
{
    public function ids() : array
    {
        return Yaml::parse(file_get_contents(__DIR__ . '/Data/user_ids.yml'));
    }

    public function amount() : int
    {
        return count($this->ids());
    }

    public function userOfIndex(int $index, array $list = null) : string
    {
        $list = null === $list ? $this->ids() : $list;

        $numberOfUserIds = count($list);
        $j = $this->mod($index, $numberOfUserIds - 1) > $numberOfUserIds
            ? 0
            : $this->mod(($numberOfUserIds - ($index - 1)), $numberOfUserIds);

        return $list[$j];
    }

    private function mod(int $first, int $second) : int
    {
        $result = $first % $second;

        return $result < 0 ? $result + $second : $result;
    }
}
