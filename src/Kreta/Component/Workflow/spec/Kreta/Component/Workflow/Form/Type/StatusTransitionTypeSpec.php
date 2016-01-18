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

namespace spec\Kreta\Component\Workflow\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class StatusTransitionTypeSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class StatusTransitionTypeSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        StatusTransitionFactory $factory,
        ObjectManager $manager
    ) {
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $this->beConstructedWith('Kreta\Component\Workflow\Model\StatusTransition', $factory, $context, $manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Form\Type\StatusTransitionType');
    }

    function it_extends_kreta_abstract_type()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Type\Abstracts\AbstractType');
    }

    function it_builds_a_form(FormBuilderInterface $builder, WorkflowInterface $workflow, StatusInterface $status)
    {
        $builder->add('name')->shouldBeCalled()->willReturn($builder);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);
        $builder->add('state', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class'   => 'Kreta\Component\Workflow\Model\Status',
            'choices' => [$status],
        ])->shouldBeCalled()->willReturn($builder);
        $builder->add('initials', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
            'mapped' => false,
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, ['workflow' => $workflow]);
    }

    function it_sets_default_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\Workflow\Model\StatusTransition'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['workflow'])->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }
}
