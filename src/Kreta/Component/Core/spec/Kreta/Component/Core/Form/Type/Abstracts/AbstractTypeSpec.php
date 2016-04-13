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

namespace spec\Kreta\Component\Core\Form\Type\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AbstractTypeSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AbstractTypeSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $context, TokenInterface $token)
    {
        $this->beAnInstanceOf('Kreta\Component\Core\Stubs\Form\Type\AbstractTypeStub');

        $context->getToken()->shouldBeCalled()->willReturn($token);
    }

    function it_throws_access_denied_exception_because_the_user_is_not_logged_and_context_is_passed(
        ObjectManager $manager,
        TokenStorageInterface $context,
        TokenInterface $token
    ) {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new AccessDeniedException())
            ->during('__construct', ['data-class', Argument::type('Object'), $context, $manager]);
    }

    function it_builds_form(
        FormBuilderInterface $builder,
        ObjectManager $manager,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(
        OptionsResolver $resolver,
        ObjectManager $manager,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $resolver->setDefaults(Argument::withKey('data_class'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }

    function it_gets_name(
        ObjectManager $manager,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $this->getName()->shouldReturn('form_type_name');
    }
}
