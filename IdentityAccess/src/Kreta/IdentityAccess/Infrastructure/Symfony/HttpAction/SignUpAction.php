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

use BenGorUser\User\Application\Command\LogIn\LogInUserCommand;
use BenGorUser\User\Application\Query\UserOfInvitationTokenHandler;
use BenGorUser\User\Application\Query\UserOfInvitationTokenQuery;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\Exception\UserInactiveException;
use BenGorUser\User\Domain\Model\Exception\UserPasswordInvalidException;
use BenGorUser\User\Domain\Model\Exception\UserTokenExpiredException;
use BenGorUser\User\Infrastructure\CommandBus\UserCommandBus;
use Kreta\IdentityAccess\Infrastructure\Symfony\Form\FormErrorSerializer;
use Kreta\IdentityAccess\Infrastructure\Symfony\Form\Type\SignUpType;
use Kreta\SharedKernel\Application\CommandBus;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class SignUpAction
{
    private $queryHandler;
    private $formFactory;
    private $commandBus;
    private $jwtEncoder;
    private $userCommandBus;

    public function __construct(
        UserOfInvitationTokenHandler $queryHandler,
        FormFactoryInterface $formFactory,
        CommandBus $commandBus,
        JWTEncoderInterface $jwtEncoder,
        UserCommandBus $userCommandBus
    ) {
        $this->queryHandler = $queryHandler;
        $this->formFactory = $formFactory;
        $this->commandBus = $commandBus;
        $this->jwtEncoder = $jwtEncoder;
        $this->userCommandBus = $userCommandBus;
    }

    public function __invoke(Request $request)
    {
        $invitationToken = $request->query->get('invitation-token');
        try {
            // we need to know if the invitation token given exists in
            // database, in case that it isn't, it throws 404.
            $user = $this->queryHandler->__invoke(new UserOfInvitationTokenQuery($invitationToken));
        } catch (UserDoesNotExistException $exception) {
            throw new NotFoundHttpException();
        } catch (UserTokenExpiredException $exception) {
            throw new NotFoundHttpException();
        } catch (\InvalidArgumentException $exception) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->createNamedBuilder('', SignUpType::class, null, [
            'roles'            => ['ROLE_USER'],
            'invitation_token' => $invitationToken,
        ])->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->commandBus->handle($form->getData());
            try {
                $this->userCommandBus->handle(
                    new LogInUserCommand(
                        $user['email'],
                        $form->getData()->password()
                    )
                );
            } catch (UserDoesNotExistException $exception) {
                throw new NotFoundHttpException();
            } catch (UserInactiveException $exception) {
                throw new NotFoundHttpException();
            } catch (UserPasswordInvalidException $exception) {
                throw new BadCredentialsException();
            }
            $token = $this->jwtEncoder->encode(['email' => $user['email']]);

            return new JsonResponse(['token' => $token]);
        }

        return new JsonResponse(FormErrorSerializer::errors($form), 400);
    }
}
