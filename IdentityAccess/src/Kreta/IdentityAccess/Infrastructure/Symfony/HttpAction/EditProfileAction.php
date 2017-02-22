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
use BenGorUser\UserBundle\Security\UserProvider;
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
    private $userProvider;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        UserCommandBus $commandBus,
        JWTEncoderInterface $encoder,
        UserProvider $userProvider
    ) {
        $this->formFactory = $formFactory;
        $this->commandBus = $commandBus;
        $this->tokenStorage = $tokenStorage;
        $this->encoder = $encoder;
        $this->userProvider = $userProvider;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $form = $this->formFactory->createNamed('', EditProfileType::class, null, ['user_id' => $user->id]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $this->commandBus->handle($data);

                // The edit profile can change the email so, the token refresh
                // is needed to maintain the correct authentication.
                $token = $this->encoder->encode(['email' => $data->email()]);

                // Refresh the current user with the updated values
                // stored in the database, because it is not possible determine
                // the user image's filename.
                $user = $this->userProvider->loadUserByUsername($data->email());

                return new JsonResponse([
                    'user_id'    => $data->id(),
                    'email'      => $data->email(),
                    'user_name'  => $data->username(),
                    'token'      => $token,
                    'first_name' => $data->firstName(),
                    'last_name'  => $data->lastName(),
                    'image'      => $user->image,
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
