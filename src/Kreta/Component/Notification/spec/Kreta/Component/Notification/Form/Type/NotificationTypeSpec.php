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

namespace spec\Kreta\Component\Notification\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NotificationTypeSpec.
 *
 * @package spec\Kreta\Component\Notification\Form\Type
 */
class NotificationTypeSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $context, TokenInterface $token, UserInterface $user)
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
        $builder->add('read', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
            'choices'           => [
                true  => 'read',
                false => 'unread',
            ],
            'choices_as_values' => true,
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, []);
    }
}
