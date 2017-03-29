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
use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddMemberToOrganization
{
    private $commandBus;

    private $currentUser;

    public function __construct(CommandBus $commandBus, TokenStorageInterface $tokenStorage)
    {
        $this->commandBus = $commandBus;
        $this->currentUser = $tokenStorage->getToken()->getUser();
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $userId = $request->get('userId');
        $organizationId = $request->get('organizationId');
        $this->commandBus->handle(
            new AddOrganizationMemberToOrganizationCommand($userId, $organizationId, $this->currentUser->getUserName())
        );

        return new JsonResponse();
    }
}
