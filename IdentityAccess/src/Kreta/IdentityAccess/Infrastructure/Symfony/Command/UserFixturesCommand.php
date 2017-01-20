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

namespace Kreta\IdentityAccess\Infrastructure\Symfony\Command;

use BenGorUser\User\Application\Command\SignUp\SignUpUserCommand;
use BenGorUser\User\Infrastructure\CommandBus\UserCommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserFixturesCommand extends Command
{
    const USER_IDS = [
        'da49c01f-2e99-45ee-9557-eb3eb57b06c5',
        'a38f8ef4-400b-4229-a5ff-712ff5f72b27',
        '6ff552df-12a6-41ce-8a6a-dae43fe6f9fe',
        '1d2cf7e0-4d99-4a9c-ab4b-e9ccb69a424e',
        '9ae553f1-bb20-4dd3-8250-3a1c3cc7e071',
        '04837db2-a7fc-461d-861c-4e513e3debe7',
        '5230ca7e-282f-40b5-9ef3-1feea78209d5',
        '85ab2baa-c019-4d7f-a22d-ba53c1e6723f',
        '565dd4e6-89b5-4e07-9e56-ef80ec222b44',
        'cf8b612b-c521-429c-86e9-7b4be5bbf614',
        'a86ab75b-7c52-4d3a-a4c0-e419f7318172',
        '34eaa88b-85b6-4e5f-af91-524de69bb53f',
        '8eb29ed7-93b2-4c94-bb9b-ad4b323ad8c5',
        '61c0d185-fc68-46f2-9c5f-783dc6096029',
        'f444df95-0087-47bd-8f72-8e9499077a99',
        '4ab9f704-c918-47bc-a4f3-93e15b5cfbfb',
        '5e5a8003-a0f0-4e7a-9d87-20f1f548a4b0',
        'e0b2e06a-54bd-4c2b-923c-5e3077e6c8d8',
        '5dd6aaed-fa13-4ea8-b8a5-ab2a1c49339c',
        '441d0c07-b951-41e2-9d4d-ce2273fdfdf1',
        '24a0843f-ce58-4444-96bb-9af26fd61c21',
        '6704c278-e106-449f-a73d-2508e96f6177',
        'cab06bb8-a124-4e70-9d4a-a1a4d15b62fb',
        '05ee2f71-b1b4-4d1d-8e76-116090ee97f2',
        '88e2e331-6937-4d00-a8f4-9d05ffe09d36',
        '1106e034-d6b8-46c0-a393-9f0fd92d18a1',
        '6c46aea0-7046-427f-ab75-1d87c0148457',
        '1f4199c5-150d-4f94-85e7-40497458e4ee',
        '0659f3d0-4883-4bb5-a8dd-d8215c9dc369',
        '3bf979cb-7f82-4de5-9b81-5a9a868505ce',
    ];

    private $commandBus;

    public function __construct(UserCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('kreta:identity-access:fixtures:users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (self::USER_IDS as $key => $userId) {
            $this->commandBus->handle(
                new SignUpUserCommand(
                    'user' . $key . '@kreta.io',
                    '123456',
                    ['ROLE_USER'],
                    $userId
                )
            );
        }

        $output->writeln('User population is successfully done');
    }
}
