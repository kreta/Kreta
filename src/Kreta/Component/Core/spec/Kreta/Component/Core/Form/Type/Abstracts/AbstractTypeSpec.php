<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Form\Type\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AbstractTypeSpec.
 *
 * @package spec\Kreta\Component\Core\Form\Type\Abstracts
 */
class AbstractTypeSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $context, TokenInterface $token)
    {
        $this->beAnInstanceOf('Kreta\Component\Core\Stubs\Form\Type\AbstractTypeStub');

        $context->getToken()->shouldBeCalled()->willReturn($token);
    }

    function it_throws_access_denied_exception_because_the_user_is_not_logged_and_context_is_passed(
        ObjectManager $manager,
        SecurityContextInterface $context,
        TokenInterface $token
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new AccessDeniedException())
            ->during('__construct', ['data-class', Argument::type('Object'), $context, $manager]);
    }

    function it_builds_form(
        FormBuilderInterface $builder,
        ObjectManager $manager,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $this->buildForm($builder, []);
    }

    function it_sets_default_options(
        OptionsResolverInterface $resolver,
        ObjectManager $manager,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $resolver->setDefaults(Argument::withKey('data_class'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);

        $this->setDefaultOptions($resolver);
    }
    
    function it_gets_name(
        ObjectManager $manager,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('data-class', Argument::type('Object'), $context, $manager);

        $this->getName()->shouldReturn('form_type_name');
    }
}
