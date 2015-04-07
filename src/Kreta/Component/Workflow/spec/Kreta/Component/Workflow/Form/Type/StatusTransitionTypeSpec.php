<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class StatusTransitionTypeSpec.
 *
 * @package spec\Kreta\Component\Workflow\Form\Type
 */
class StatusTransitionTypeSpec extends ObjectBehavior
{
    function let(
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        StatusTransitionFactory $factory,
        ObjectManager $manager
    )
    {
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
        $builder->add('state', 'entity', [
            'class'   => 'Kreta\Component\Workflow\Model\Status',
            'choices' => [$status]
        ])->shouldBeCalled()->willReturn($builder);
        $builder->add('initials', null, [
            'mapped' => false
        ])->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, ['workflow' => $workflow]);
    }

    function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('data_class', 'Kreta\Component\Workflow\Model\StatusTransition'))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('csrf_protection', false))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withEntry('empty_data', Argument::type('closure')))
            ->shouldBeCalled()->willReturn($resolver);
        $resolver->setRequired(['workflow'])->shouldBeCalled()->willReturn($resolver);

        $this->setDefaultOptions($resolver);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('kreta_workflow_status_transition_type');
    }
}
