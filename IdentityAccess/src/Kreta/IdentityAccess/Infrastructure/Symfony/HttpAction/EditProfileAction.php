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

use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Infrastructure\CommandBus\UserCommandBus;
use BenGorUser\UserBundle\Form\FormErrorSerializer;
use Kreta\IdentityAccess\Domain\Model\User\UserEmailAlreadyExistsException;
use Kreta\IdentityAccess\Domain\Model\User\UsernameAlreadyExistsException;
use Kreta\IdentityAccess\Infrastructure\Symfony\Form\Type\EditProfileType;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditProfileAction
{
    private $tokenStorage;
    private $formFactory;
    private $commandBus;
    private $encoder;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        UserCommandBus $commandBus,
        JWTEncoderInterface $encoder
    ) {
        $this->formFactory = $formFactory;
        $this->commandBus = $commandBus;
        $this->tokenStorage = $tokenStorage;
        $this->encoder = $encoder;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $userId = $this->tokenStorage->getToken()->getUser()->id;

        $form = $this->formFactory->createNamed('', EditProfileType::class, null, ['user_id' => $userId]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $this->commandBus->handle($data);
                $token = $this->encoder->encode(['email' => $data->email()]);

                return new JsonResponse([
                    'user_id'    => $data->id(),
                    'email'      => $data->email(),
                    'username'   => $data->userName(),
                    'token'      => $token,
                    'first_name' => $data->firstName(),
                    'last_name'  => $data->lastName(),
                ]);
            } catch (UserDoesNotExistException $exception) {
                return new JsonResponse(
                    sprintf(
                        'Does not exist any user with "%s" user id.',
                        $data->id()
                    ), 400);
            } catch (UserEmailAlreadyExistsException $exception) {
                return new JsonResponse(
                    sprintf(
                        'The given "%s" email is already in use',
                        $data->email()
                    ), 400);
            } catch (UsernameAlreadyExistsException $exception) {
                return new JsonResponse(
                    sprintf(
                        'The given "%s" username is already in use',
                        $data->username()
                    ), 400);
            }
        }

        return new JsonResponse(FormErrorSerializer::errors($form), 400);
    }
}
