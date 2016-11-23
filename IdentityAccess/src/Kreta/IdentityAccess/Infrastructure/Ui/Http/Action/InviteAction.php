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

namespace Kreta\IdentityAccess\Infrastructure\Ui\Http\Action;

use BenGorUser\User\Domain\Model\Exception\UserAlreadyExistException;
use BenGorUser\User\Infrastructure\CommandBus\UserCommandBus;
use Kreta\IdentityAccess\Infrastructure\Ui\Form\FormErrorSerializer;
use Kreta\IdentityAccess\Infrastructure\Ui\Form\Type\InviteType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InviteAction
{
    private $formFactory;
    private $commandBus;

    public function __construct(FormFactoryInterface $formFactory, UserCommandBus $commandBus)
    {
        $this->formFactory = $formFactory;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        $form = $this->formFactory
            ->createNamedBuilder('', InviteType::class, null, ['roles' => ['ROLE_USER']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $this->commandBus->handle($form->getData());

                return new JsonResponse([
                    'user_id' => $form->getData()->id(),
                    'email'   => $form->getData()->email(),
                    'role'    => $form->getData()->roles(),
                ]);
            } catch (UserAlreadyExistException $exception) {
                return new JsonResponse(
                    sprintf(
                        'The %s email is already invited',
                        $form->getData()->email()
                    ),
                    409
                );
            }
        }

        return new JsonResponse(FormErrorSerializer::errors($form), 400);
    }
}
