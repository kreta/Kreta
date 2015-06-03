<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
 * @package spec\Kreta\Component\Project\Form\Type\
 */
class ParticipantTypeSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ParticipantFactory $factory
    )
    {
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
        $builder->add('role', 'kreta_project_role_type')->shouldBeCalled()->willReturn($builder);
        $builder->add('user', 'entity', [
            'class'   => 'Kreta\Component\User\Model\User',
            'choices' => [$user]
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

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_project_participant_type');
    }
}
