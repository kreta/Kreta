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

namespace Kreta\IdentityAccess\Infrastructure\Ui\Web\Controller;

use BenGorUser\User\Application\Command\SignUp\ByInvitationSignUpUserCommand;
use BenGorUser\User\Application\Query\UserOfInvitationTokenQuery;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\Exception\UserTokenExpiredException;
use BenGorUser\UserBundle\Form\Type\SignUpByInvitationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpAction extends Controller
{
//    public function byInvitationAction(Request $request)
//    {
//        $this->get('command_bus')->handle(
//            new ByInvitationSignUpUserCommand('11', '11')
//        );
//
//        return new Response();
//    }

    public function byInvitationAction(Request $request, $userClass = 'user', $firewall = 'main')
    {
        $invitationToken = $request->query->get('invitation-token');
        try {
            // we need to know if the invitation token given exists in
            // database, in case that it isn't, it throws 404.
            $user = $this->get('bengor_user.' . $userClass . '.by_invitation_token_query')->__invoke(
                new UserOfInvitationTokenQuery($invitationToken)
            );

            // Convert to an object implementing Symfony's UserInterface
            $dataTransformer = $this->get('bengor_user.' . $userClass . '.symfony_data_transformer');
            $dataTransformer->write($user);
            $user = $dataTransformer->read();
        } catch (UserDoesNotExistException $exception) {
            throw $this->createNotFoundException();
        } catch (UserTokenExpiredException $exception) {
            throw $this->createNotFoundException();
        } catch (\InvalidArgumentException $exception) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(SignUpByInvitationType::class, null, [
            'roles'            => $this->getParameter('bengor_user.' . $userClass . '_default_roles'),
            'invitation_token' => $invitationToken,
        ]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->get('command_bus')->handle($form->getData());
                $this->addFlash('notice', $this->get('translator')->trans(
                    'sign_up.success_flash', [], 'BenGorUser'
                ));

                return $this
                    ->get('security.authentication.guard_handler')
                    ->authenticateUserAndHandleSuccess(
                        $user,
                        $request,
                        $this->get('bengor_user.' . $userClass . '.form_login_authenticator'),
                        $firewall
                    );
            }
        }

        return $this->render('@BenGorUser/sign_up/by_invitation.html.twig', [
            'email' => $user->getUsername(),
            'form'  => $form->createView(),
        ]);
    }
}
