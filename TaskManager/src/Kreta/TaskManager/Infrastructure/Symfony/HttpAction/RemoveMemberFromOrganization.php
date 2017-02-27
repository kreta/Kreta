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

namespace Kreta\TaskManager\Infrastructure\Symfony\HttpAction;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\TaskManager\Application\Command\Organization\RemoveOrganizationMemberToOrganizationCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RemoveMemberFromOrganization
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $userId = $request->get('userId');
        $organizationId = $request->get('organizationId');
        $removerId = $request->get('removerId');
        $this->commandBus->handle(
            new RemoveOrganizationMemberToOrganizationCommand($userId, $organizationId, $removerId)
        );

        return new JsonResponse();
    }
}
