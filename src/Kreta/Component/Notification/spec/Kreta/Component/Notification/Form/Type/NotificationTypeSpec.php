<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NotificationTypeSpec.
 *
 * @package spec\Kreta\Component\Notification\Form\Type
 */
class NotificationTypeSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $context, TokenInterface $token, UserInterface $user)
    {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Form\Type\NotificationType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder)
    {
        $builder->add('read', 'choice', [
            'choices'  => [true => 'read', false  => 'unread']
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_notification_notification_type');
    }
}
