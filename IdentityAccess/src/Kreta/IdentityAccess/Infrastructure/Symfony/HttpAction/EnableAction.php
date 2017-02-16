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

namespace Kreta\IdentityAccess\Infrastructure\Symfony\HttpAction;

use BenGorUser\User\Application\Command\Enable\EnableUserCommand;
use BenGorUser\User\Domain\Model\Exception\UserTokenNotFoundException;
use Kreta\SharedKernel\Application\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EnableAction
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $confirmationToken = $request->query->get('confirmation-token');
        if (null === $confirmationToken) {
            return new JsonResponse(null, 404);
        }

        try {
            $this->commandBus->handle(
                new EnableUserCommand($confirmationToken)
            );

            return new JsonResponse();
        } catch (UserTokenNotFoundException $exception) {
            return new JsonResponse(
                sprintf(
                    'The "%s" confirmation token does not exist',
                    $confirmationToken
                ),
                400
            );
        }
    }
}
