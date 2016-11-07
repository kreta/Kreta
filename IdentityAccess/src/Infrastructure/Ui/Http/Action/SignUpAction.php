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

use BenGorUser\User\Application\DataTransformer\UserDataTransformer;
use BenGorUser\User\Application\Query\UserOfInvitationTokenHandler;
use BenGorUser\User\Application\Query\UserOfInvitationTokenQuery;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\Exception\UserTokenExpiredException;
use BenGorUser\UserBundle\Form\Type\SignUpByInvitationType;
use BenGorUser\UserBundle\Security\FormLoginAuthenticator;
use Kreta\SharedKernel\Application\CommandBus;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class SignUpAction
{
    private $queryHandler;
    private $dataTransformer;
    private $formFactory;
    private $commandBus;
    private $flashBag;
    private $translator;
    private $guardAuthenticatorHandler;
    private $authenticator;
    private $twig;

    public function __construct(
        UserOfInvitationTokenHandler $queryHandler,
        UserDataTransformer $dataTransformer,
        FormFactoryInterface $formFactory,
        CommandBus $commandBus,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        FormLoginAuthenticator $authenticator,
        EngineInterface $twig
    ) {
        $this->queryHandler = $queryHandler;
        $this->dataTransformer = $dataTransformer;
        $this->formFactory = $formFactory;
        $this->commandBus = $commandBus;
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->guardAuthenticatorHandler = $guardAuthenticatorHandler;
        $this->authenticator = $authenticator;
        $this->twig = $twig;
    }

    public function __invoke(Request $request)
    {
        $invitationToken = $request->query->get('invitation-token');
        try {
            // we need to know if the invitation token given exists in
            // database, in case that it isn't, it throws 404.
            $user = $this->queryHandler->__invoke(new UserOfInvitationTokenQuery($invitationToken));

            // Convert to an object implementing Symfony's UserInterface
            $this->dataTransformer->write($user);
            $user = $this->dataTransformer->read();
        } catch (UserDoesNotExistException $exception) {
            throw new NotFoundHttpException();
        } catch (UserTokenExpiredException $exception) {
            throw new NotFoundHttpException();
        } catch (\InvalidArgumentException $exception) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->create(SignUpByInvitationType::class, null, [
            'roles'            => ['ROLE_USER'],
            'invitation_token' => $invitationToken,
        ]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->commandBus->handle($form->getData());
                $this->flashBag->add('notice', $this->translator->trans('sign_up.success_flash', [], 'BenGorUser'));

                return $this->guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->authenticator,
                    'main'
                );
            }
        }

        return new Response(
            $this->twig->render('@BenGorUser/sign_up/by_invitation.html.twig', [
                'email' => $user->getUsername(),
                'form'  => $form->createView(),
            ])
        );
    }
}
