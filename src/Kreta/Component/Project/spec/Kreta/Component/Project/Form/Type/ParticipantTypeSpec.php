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

namespace spec\Kreta\Component\Project\Form\Type;

use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class ParticipantTypeSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ParticipantTypeSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ParticipantFactory $factory
    ) {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Project\Model\Participant', $factory, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Form\Type\ParticipantType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilder $builder, UserInterface $user)
    {
        $builder->add('role', 'Kreta\Component\Project\Form\Type\RoleType')->shouldBeCalled()->willReturn($builder);
        $builder->add('user', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class'   => 'Kreta\Component\User\Model\User',
            'choices' => [$user],
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, ['users' => [$user]]);
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\Project\Model\Participant'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['project'])->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(['users' => []])->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }
}
