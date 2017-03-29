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

namespace Kreta\IdentityAccess\Infrastructure\Persistence\Doctrine\DataFixtures;

use BenGorUser\User\Application\Command\SignUp\SignUpUserCommand;
use Doctrine\Common\Persistence\ObjectManager;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\DataFixtures\AbstractFixture;

class LoadUserData extends AbstractFixture
{
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
        $i = 0;
        while ($i < $this->amount()) {
            $this->commandBus()->handle(
                new SignUpUserCommand(
                    'user' . $i . '@kreta.io',
                    '123456',
                    ['ROLE_USER'],
                    $this->fakeIds()[$i]
                )
            );
            ++$i;
        }
    }
}
