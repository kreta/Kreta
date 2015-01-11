<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Controller;

use Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller\BaseRestController;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class RestControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class RestControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\RestController');
    }

    function it_extends_fos_rest_controller()
    {
        $this->shouldHaveType('FOS\RestBundle\Controller\FOSRestController');
    }

    function it_does_not_get_user_because_it_is_not_an_instance_of_kreta_user(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token
    )
    {
        $this->getUserSpec($container, $context, $token);

        $this->shouldThrow(new AccessDeniedException())->during('getUser');
    }

    function it_gets_user(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $this->getUserSpec($container, $context, $token, $user);
        
        $this->getUser()->shouldReturn($user);
    }
}
